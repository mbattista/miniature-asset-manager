<?php
declare(strict_types=1);

namespace AssetManager\Models;

use AssetManager\Error\CitrixNotFoundException;
use AssetManager\Traits\DbHelperTrait;
use AssetManager\Traits\TimestampTrait;
use DateTime;

class Citrix
{
    use TimestampTrait;
    use DbHelperTrait;

    protected array $order_items = [
        'id' => 'c.id',
        'citrix_number' => 'c.citrix_number',
        'password' => 'c.password',
        'show_id' => 'c.show_id',
        'weight' => 'weight',
    ];
    protected array $sort_items = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    protected int $id;
    protected ?string $citrix_number;
    protected ?string $password;
    protected ?string $show_id;

    public function __construct()
    {
        $this->id = 0;
        $this->citrix_number = '';
        $this->password = null;
        $this->show_id = null;
        $this->updated = null;
        $this->created = new DateTime();
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
     * @return Citrix
     */
    public function setId(int $id): Citrix
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->citrix_number;
    }

    /**
     * @param string|null $citrix_number
     * @return Citrix
     */
    public function setNumber(?string $citrix_number): Citrix
    {
        $this->citrix_number = $citrix_number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return Citrix
     */
    public function setPassword(?string $password): Citrix
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShowId(): ?string
    {
        return $this->show_id;
    }

    /**
     * @param string|null $show_id
     * @return Citrix
     */
    public function setShowId(?string $show_id): Citrix
    {
        $this->show_id = $show_id;
        return $this;
    }

    public function update()
    {
        $sql = "UPDATE citrix SET 
                    citrix_number = :citrix_number, 
                    password = :password, 
                    show_id = :show_id,
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'citrix_number' => $this->getNumber(),
            'password' => $this->getPassword(),
            'show_id' => $this->getShowId(),
        ];
        $return = $this->getDbHelper()->queryUpdate($sql, $data);
        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function create()
    {
        $sql = "INSERT INTO citrix (citrix_number, password, show_id) VALUES (:citrix_number, :password, :show_id)";

        $data = [
            'citrix_number' => $this->getNumber(),
            'password' => $this->getPassword(),
            'show_id' => $this->getShowId(),
        ];

        $return = $this->getDbHelper()->queryInsert($sql, $data);
        return $return;
    }

    public function delete()
    {
        $sql = "DELETE FROM citrix WHERE id = ?;";
        $data = [
            $this->getId(),
        ];
        $return = $this->getDbHelper()->queryDelete($sql, $data);
        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get(int $id)
    {
        $sql = "SELECT  id,
                        id,
                        citrix_number,
                        password,
                        show_id,
                        created,
                        updated
                FROM citrix
                WHERE id = :id;";
        $data = [
            'id' => $id
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (count($ar) === 0) {
            throw new CitrixNotFoundException();
        }
        $ar = array_pop($ar);

        $this->setId($ar['id']);
        if (isset($ar['citrix_number'])) {
            $this->setNumber($ar['citrix_number']);
        }
        if (isset($ar['password'])) {
            $this->setPassword($ar['password']);
        }
        if (isset($ar['show_id'])) {
            $this->setShowId($ar['show_id']);
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

    public function lists(
        int $offset,
        int $per_page,
        ?string $search_term = null,
        ?string $order_by = null,
        ?string $sort = null,
        ?bool $show_only_available = false
    ) {
        $sql = " SELECT
                         c.id,
                         c.id,
                         c.citrix_number,
                         c.password,
                         c.show_id ";
        if ($search_term === null) {
            if (isset($this->order_items[$order_by])) {
                $order_by_sql = $this->order_items[$order_by];
            } else {
                $order_by_sql = $this->order_items['id'];
            }
            if (isset($this->sort_items[$sort])) {
                $sort_sql = $this->sort_items[$sort];
            } else {
                $sort_sql = $this->sort_items['asc'];
            }
            $sql .= " FROM citrix c ";
            if ($show_only_available) {
                $sql .= " WHERE pa.citrix_id IS NULL ";
            }
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
        } else {
            $sql .= ",
                CASE
                    WHEN (citrix_number ILIKE :search_term_1) THEN 1000
                    WHEN (citrix_number ILIKE :search_term_suffix_1) THEN 100 
                    WHEN (citrix_number ILIKE :search_term_prefix_1) THEN 100
                    WHEN (citrix_number ILIKE :search_term_both_1) THEN 80
                    ELSE 0
                END 
                + CASE
                    WHEN (password ILIKE :search_term_2) THEN 800
                    WHEN (password ILIKE :search_term_suffix_2) THEN 60
                    WHEN (password ILIKE :search_term_prefix_2) THEN 60
                    WHEN (password ILIKE :search_term_both_2) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (show_id ILIKE :search_term_3) THEN 800
                    WHEN (show_id ILIKE :search_term_suffix_3) THEN 60
                    WHEN (show_id ILIKE :search_term_prefix_3) THEN 60
                    WHEN (show_id ILIKE :search_term_both_3) THEN 40
                    ELSE 0
                END  
                AS weight ";
            $sql .= " FROM citrix c ";
            $sql .= " WHERE (citrix_number ILIKE :search_term_w_1) OR (password ILIKE :search_term_w_2) OR (show_id ILIKE :search_term_w_3) ";
            if (isset($this->order_items[$order_by])) {
                $order_by_sql = $this->order_items[$order_by];
            } else {
                $order_by_sql = $this->order_items['weight'];
            }
            if (isset($this->sort_items[$sort])) {
                $sort_sql = $this->sort_items[$sort];
            } else {
                $sort_sql = $this->sort_items['desc'];
            }
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql}, id LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
            for ($i = 1; $i <= 3; $i++) {
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

    public function count(?string $search_term = null) : int
    {
        $data = [];
        $sql = "SELECT COUNT(id), COUNT(id) as total FROM citrix ";
        if ($search_term === null) {
            $sql .= ";";
        } else {
            $sql .= " WHERE (citrix_number ILIKE :search_term_w_1) OR (password ILIKE :search_term_w_2) OR (show_id ILIKE :search_term_w_3) ";
            for ($i = 1; $i <= 3; $i++) {
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

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'citrix_number' => $this->getNumber(),
            'password' => $this->getPassword(),
            'show_id' => $this->getShowId(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated(),
        ];
    }
}
