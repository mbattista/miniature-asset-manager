<?php
declare(strict_types=1);

namespace AssetManager\Models;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\PersonNotFoundException;
use AssetManager\Traits\DbHelperTrait;
use AssetManager\Traits\TimestampTrait;
use DateTime;

class Person
{
    use TimestampTrait;
    use DbHelperTrait;

    protected int $id;
    protected string $last_name;
    protected string $first_name;

    public function __construct()
    {
        $this->id = 0;
        $this->last_name = '';
        $this->first_name = '';
        $this->updated = null;
        $this->created = new DateTime('now');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Person
     */
    public function setId(int $id): Person
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return Person
     */
    public function setLastName(string $last_name): Person
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return Person
     */
    public function setFirstName(string $first_name): Person
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated(),
        ];
    }

    /**
     * @return bool
     * @throws DatabaseError
     */
    public function update()
    {
        $sql = "UPDATE person SET 
                    first_name = :first_name, 
                    last_name = :last_name, 
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
        ];
        $return = $this->getDbHelper()->queryUpdate($sql, $data);
        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return int
     * @throws DatabaseError
     */
    public function create()
    {
        $sql = "INSERT INTO person (first_name, last_name) VALUES (:first_name, :last_name)";

        $data = [
            'last_name' => $this->getLastName(),
            'first_name' => $this->getFirstName(),
        ];

        $return = $this->getDbHelper()->queryInsert($sql, $data);
        return $return;
    }

    public function delete()
    {
        $sql = "DELETE FROM person WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
        ];
        $return = $this->getDbHelper()->queryDelete($sql, $data);
        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @return $this
     * @throws PersonNotFoundException
     * @throws DatabaseError
     */
    public function get(int $id)
    {
        $sql = "SELECT id, id, last_name, first_name, created, updated FROM person WHERE id = :id;";
        $data = [
            'id' => $id,
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (count($ar) === 0) {
            throw new PersonNotFoundException();
        }
        $ar = array_pop($ar);

        $this->setId((int)$ar['id']);
        if (isset($ar['last_name'])) {
            $this->setLastName($ar['last_name']);
        }
        if (isset($ar['first_name'])) {
            $this->setFirstName($ar['first_name']);
        }
        if (isset($ar['created'])) {
            $created = new DateTime($ar['created']);
            $this->setCreated($created);
        }
        if (isset($ar['updated'])) {
            $updated = new DateTime($ar['updated']);
            $this->setupdated($updated);
        }

        return $this;
    }

    /**
     * @param int $offset
     * @param int $per_page
     * @param string|null $search_term
     * @return array
     * @throws DatabaseError
     */
    public function lists(int $offset, int $per_page, ?string $search_term = null)
    {
        $sql = "SELECT id, id, first_name, last_name ";
        if ($search_term === null) {
            $sql .= " FROM person ORDER BY id LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
        } else {
            $sql .= ",
                CASE
                    WHEN (last_name ILIKE :search_term_1) THEN 1000
                    WHEN (last_name ILIKE :search_term_suffix_1) THEN 100
                    WHEN (last_name ILIKE :search_term_prefix_1) THEN 100
                    WHEN (last_name ILIKE :search_term_both_1) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (first_name ILIKE :search_term_2) THEN 1000
                    WHEN (first_name ILIKE :search_term_suffix_2) THEN 100
                    WHEN (first_name ILIKE :search_term_prefix_2) THEN 100
                    WHEN (first_name ILIKE :search_term_both_2) THEN 80
                    ELSE 0
                END ";
            $sql .= " AS weight ";
            $sql .= " FROM person ";
            $sql .= " WHERE (last_name ILIKE :search_term_w_1) OR (first_name ILIKE :search_term_w_2) ";
            $sql .= " ORDER BY weight, id LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
            for ($i = 1; $i <= 2; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
        }
        $ar = $this->getDbHelper()->querySelect($sql, $data);

        return array_values($ar);
    }

    /**
     * @param string|null $search_term
     * @return int
     * @throws DatabaseError
     */
    public function count(?string $search_term = null) : int
    {
        $sql = "SELECT COUNT(id), COUNT(id) as total FROM person ";
        $data = [];
        if ($search_term === null) {
            $sql .= ";";
        } else {
            $sql .= " WHERE (last_name ILIKE :search_term_w_1) OR (first_name ILIKE :search_term_w_2) ";
            for ($i = 1; $i <= 2; $i++) {
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
        }
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        $ar = array_pop($ar);
        if (isset($ar) && isset($ar['total'])) {
            return (int)$ar['total'];
        } else {
            return 0;
        }
    }
}
