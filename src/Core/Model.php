<?php

namespace App\Core;

use PDO;

/**
 * Modèle racine fournissant des méthodes d'accès sécurisé à la base de données
 */
abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère tous les enregistrements
     */
    public function all(string $orderBy = 'id DESC'): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    /**
     * Recherche un enregistrement par sa clé primaire
     */
    public function find(int|string $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Recherche les enregistrements correspondant à des critères simples
     */
    public function where(array $conditions, string $orderBy = 'id DESC'): array
    {
        $clauses = [];
        $params = [];

        foreach ($conditions as $field => $value) {
            $clauses[] = "{$field} = :{$field}";
            $params[$field] = $value;
        }

        $sql = "SELECT * FROM {$this->table}";
        if (!empty($clauses)) {
            $sql .= " WHERE " . implode(' AND ', $clauses);
        }
        $sql .= " ORDER BY {$orderBy}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Recherche le premier enregistrement correspondant
     */
    public function findFirst(array $conditions): ?array
    {
        $results = $this->where($conditions, 'id ASC LIMIT 1');
        return $results[0] ?? null;
    }

    /**
     * Insère un nouvel enregistrement
     */
    public function create(array $data): int
    {
        $fields = array_keys($data);
        $columns = implode(', ', $fields);
        $placeholders = ':' . implode(', :', $fields);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Met à jour un enregistrement par son identifiant
     */
    public function update(int|string $id, array $data): bool
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE {$this->primaryKey} = :_id";
        $data['_id'] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Supprime un enregistrement
     */
    public function delete(int|string $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compte le nombre total d'enregistrements
     */
    public function count(array $conditions = []): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $params = [];

        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $field => $value) {
                $clauses[] = "{$field} = :{$field}";
                $params[$field] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $clauses);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Exécute une requête SQL brute avec paramètres préparés
     */
    public function rawQuery(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
