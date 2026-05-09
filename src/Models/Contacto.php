<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'formulario_contacto';

    protected $fillable = [
        'nombre', 'email', 'telefono', 'asunto', 'mensaje', 'estatus', 'ip_address', 'user_agent'   ];
    private $pdo;
    
    
    
    public function obtenerTodos(int $limit = 50, int $offset = 0, string $filtroEstatus = ''): array
    {
        $sql = "SELECT * FROM formulario_contacto";
        $params = [];
        
        if (!empty($filtroEstatus)) {
            $sql .= " WHERE estatus = :estatus";
            $params[':estatus'] = $filtroEstatus;
        }
        
        $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        if (!empty($filtroEstatus)) {
            $stmt->bindValue(':estatus', $filtroEstatus);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function contarTotal(string $filtroEstatus = ''): int
    {
        $sql = "SELECT COUNT(*) FROM formulario_contacto";
        $params = [];
        
        if (!empty($filtroEstatus)) {
            $sql .= " WHERE estatus = :estatus";
            $params[':estatus'] = $filtroEstatus;
        }
        
        $stmt = $this->pdo->prepare($sql);
        if (!empty($filtroEstatus)) {
            $stmt->bindValue(':estatus', $filtroEstatus);
        }
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
    
    public function actualizarEstatus(int $id, string $estatus, string $adminUsuario, string $notas = ''): bool
    {
        $sql = "UPDATE formulario_contacto 
                SET estatus = :estatus, 
                    admin_usuario = :admin_usuario, 
                    notas_admin = :notas,
                    fecha_respuesta = CASE 
                        WHEN :estatus = 'respondido' THEN NOW() 
                        ELSE fecha_respuesta 
                    END
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':estatus' => $estatus,
            ':admin_usuario' => $adminUsuario,
            ':notas' => $notas
        ]);
    }
    
   
    public static function getEstatusOptions(): array
    {
        return [
            'nuevo' => ['label' => 'Nuevo', 'color' => '#007bff', 'icon' => '📧'],
            'leido' => ['label' => 'Leído', 'color' => '#6c757d', 'icon' => '👁️'],
            'en_proceso' => ['label' => 'En Proceso', 'color' => '#ffc107', 'icon' => '⏳'],
            'respondido' => ['label' => 'Respondido', 'color' => '#17a2b8', 'icon' => '💬'],
            'resuelto' => ['label' => 'Resuelto', 'color' => '#28a745', 'icon' => '✅'],
            'cerrado' => ['label' => 'Cerrado', 'color' => '#6c757d', 'icon' => '🔒'],
            'spam' => ['label' => 'Spam', 'color' => '#dc3545', 'icon' => '🚫']
        ];
    }
}