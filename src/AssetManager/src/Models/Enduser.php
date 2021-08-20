<?php
declare(strict_types=1);

namespace AssetManager\Models;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\UserNotFoundException;
use AssetManager\Traits\DbHelperTrait;
use AssetManager\Traits\TimestampTrait;
use DateTime;

class Enduser
{
    use DbHelperTrait;
    use TimestampTrait;

    protected array $order_items = [
        'id' => 'u.id',
        'weight' => 'weight',
        'last_name' => 'p.last_name',
        'first_name' => 'p.first_name',
        'name' => 'q.name',
    ];
    protected array $sort_items = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    protected int $id;
    protected ?bool $active;
    protected ?string $text;
    protected ?int $person;
    protected ?int $place;
    protected ?string $tel;
    protected ?string $mobile;
    protected ?string $email;

    protected array $return_array = [];

    public function __construct()
    {
        $this->id = 0;
        $this->active = false;
        $this->text = null;
        $this->person = null;
        $this->place = null;
        $this->tel = null;
        $this->mobile = null;
        $this->email = null;
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
     * @return $this
     */
    public function setId(int $id): Enduser
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     * @return Enduser
     */
    public function setActive(?bool $active): Enduser
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return Enduser
     */
    public function setText(?string $text): Enduser
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerson(): ?int
    {
        return $this->person;
    }

    /**
     * @param int|null $person
     * @return Enduser
     */
    public function setPerson(?int $person): Enduser
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPlace(): ?int
    {
        return $this->place;
    }

    /**
     * @param int|null $place
     * @return Enduser
     */
    public function setPlace(?int $place): Enduser
    {
        $this->place = $place;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @param string|null $tel
     * @return Enduser
     */
    public function setTel(?string $tel): Enduser
    {
        $this->tel = $tel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string|null $mobile
     * @return Enduser
     */
    public function setMobile(?string $mobile): Enduser
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Enduser
     */
    public function setEmail(?string $email): Enduser
    {
        $this->email = $email;
        return $this;
    }

    public function toArray(): array
    {
        return $this->return_array;
    }

    /**
     * @return bool
     * @throws DatabaseError
     */
    public function update(): bool
    {
        $sql = "UPDATE enduser SET 
                    person_id = :person, 
                    place_id = :place,
                    active = :active,
                    text = :text,
                    tel = :tel,
                    mobile = :mobile,
                    email = :email, 
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'person' => $this->getPerson(),
            'place' => $this->getPlace(),
            'active' => ($this->getActive() ? 'true' : 'false'),
            'text' => $this->getText(),
            'tel' => $this->getTel(),
            'mobile' => $this->getMobile(),
            'email' => $this->getEmail(),
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
        $sql = "INSERT INTO enduser (person_id, place_id, active, text, tel, mobile, email) VALUES (:person, :place, :active, :text, :tel, :mobile, :email)";

        $data = [
            'person' => $this->getPerson(),
            'place' => $this->getPlace(),
            'active' => ($this->getActive() ? 'true' : 'false'),
            'text' => $this->getText(),
            'tel' => $this->getTel(),
            'mobile' => $this->getMobile(),
            'email' => $this->getEmail(),
        ];

        $return = $this->getDbHelper()->queryInsert($sql, $data);
        return $return;
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM enduser WHERE id = ?;";
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

    /**
     * @param int $id
     * @return $this
     * @throws UserNotFoundException
     * @throws DatabaseError
     */
    public function get(int $id): Enduser
    {
        $sql = "
            SELECT 
                u.id,
                u.id,
                u.person_id,
                u.place_id,
                u.text,
                u.active,
                u.tel,
                u.mobile,
                u.email,
                u.created,
                u.updated,
                p.last_name,
                p.first_name,
                q.name,
                q.city
            FROM enduser u
            LEFT OUTER JOIN person p ON u.person_id = p.id
            LEFT OUTER JOIN place q on u.place_id = q.id
            WHERE u.id = :id;
        ";
        $data = [
            'id' => $id,
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (count($ar) === 0) {
            throw new UserNotFoundException();
        }
        $ar = array_pop($ar);

        $this->setId((int)$ar['id']);
        $this->return_array['id'] = (int)$ar['id'];
        if (isset($ar['person_id'])) {
            $this->setPerson($ar['person_id']);
            $this->return_array['person'] = $ar['person_id'];
        }
        if (isset($ar['place_id'])) {
            $this->setPlace($ar['place_id']);
            $this->return_array['place'] = $ar['place_id'];
        }
        if (isset($ar['text'])) {
            $this->setText($ar['text']);
            $this->return_array['text'] = $ar['text'];
        }
        if (isset($ar['active'])) {
            $this->setActive($ar['active']);
            $this->return_array['active'] = $ar['active'];
        }
        if (isset($ar['tel'])) {
            $this->setTel($ar['tel']);
            $this->return_array['tel'] = $ar['tel'];
        }
        if (isset($ar['mobile'])) {
            $this->setMobile($ar['mobile']);
            $this->return_array['mobile'] = $ar['mobile'];
        }
        if (isset($ar['email'])) {
            $this->setEmail($ar['email']);
            $this->return_array['email'] = $ar['email'];
        }
        if (isset($ar['created'])) {
            $created = new DateTime($ar['created']);
            $this->setCreated($created);
            $this->return_array['created'] = $ar['created'];
        }
        if (isset($ar['updated'])) {
            $updated = new DateTime($ar['updated']);
            $this->setupdated($updated);
            $this->return_array['updated'] = $ar['updated'];
        }
        if (isset($ar['last_name'])) {
            $this->return_array['last_name'] = $ar['last_name'];
        }
        if (isset($ar['first_name'])) {
            $this->return_array['first_name'] = $ar['first_name'];
        }
        if (isset($ar['name'])) {
            $this->return_array['name'] = $ar['name'];
        }
        if (isset($ar['city'])) {
            $this->return_array['city'] = $ar['city'];
        }

        return $this;
    }

    /**
     * @param int $offset
     * @param int $per_page
     * @param string|null $search_term
     * @param int|null $person
     * @param int|null $place
     * @param string|null $order_by
     * @param string|null $sort
     * @param bool $show_inactive
     * @return array
     * @throws DatabaseError
     */
    public function lists(
        int $offset,
        int $per_page,
        ?string $search_term = null,
        ?int $person = null,
        ?int $place = null,
        ?string $order_by = null,
        ?string $sort = null,
        bool $show_inactive = false
    ): array {
        $data = [];
        $sql = "SELECT 
                u.id,
                u.id,
                u.person_id,
                u.place_id,
                u.text,
                u.active,
                u.tel,
                u.mobile,
                u.email,
                p.last_name,
                p.first_name,
                q.name,
                q.city ";
        if ($search_term === null) {
            $sql .= " FROM enduser u
            LEFT OUTER JOIN person p ON u.person_id = p.id
            LEFT OUTER JOIN place q on u.place_id = q.id ";
            if ($place !== null) {
                $sql .= " WHERE u.place_id = :place ";
                $data['place'] = $place;
                if ($person !== null) {
                    $sql .= " AND u.person_id = :person ";
                    $data['person'] = $person;
                }
                if (!$show_inactive) {
                    $sql .= " AND u.active = true ";
                }
            } elseif ($person !== null) {
                $sql .= " WHERE u.person_id = :person ";
                $data['person'] = $person;
                if (!$show_inactive) {
                    $sql .= " AND u.active = true ";
                }
            } elseif (!$show_inactive) {
                $sql .= " WHERE u.active = true ";
            }
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
            $sql .= "ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data['per_page'] = $per_page;
            $data['offset'] = $offset;
        } else {
            $sql .= ",
                CASE
                    WHEN (p.last_name ILIKE :search_term_1) THEN 1000 
                    WHEN (p.last_name ILIKE :search_term_suffix_1) THEN 100
                    WHEN (p.last_name ILIKE :search_term_prefix_1) THEN 80
                    WHEN (p.last_name ILIKE :search_term_both_1) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (p.first_name ILIKE :search_term_2) THEN 1000 
                    WHEN (p.first_name ILIKE :search_term_suffix_2) THEN 100
                    WHEN (p.first_name ILIKE :search_term_prefix_2) THEN 80
                    WHEN (p.first_name ILIKE :search_term_both_2) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (u.text ILIKE :search_term_4) THEN 1000 
                    WHEN (u.text ILIKE :search_term_suffix_4) THEN 60
                    WHEN (u.text ILIKE :search_term_prefix_4) THEN 40
                    WHEN (u.text ILIKE :search_term_both_4) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (u.tel ILIKE :search_term_5) THEN 1000 
                    WHEN (u.tel ILIKE :search_term_suffix_5) THEN 100
                    WHEN (u.tel ILIKE :search_term_prefix_5) THEN 80
                    WHEN (u.tel ILIKE :search_term_both_5) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (u.mobile ILIKE :search_term_6) THEN 1000 
                    WHEN (u.mobile ILIKE :search_term_suffix_6) THEN 100
                    WHEN (u.mobile ILIKE :search_term_prefix_6) THEN 80
                    WHEN (u.mobile ILIKE :search_term_both_6) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (q.name ILIKE :search_term_7) THEN 1000 
                    WHEN (q.name ILIKE :search_term_suffix_7) THEN 100
                    WHEN (q.name ILIKE :search_term_prefix_7) THEN 80
                    WHEN (q.name ILIKE :search_term_both_7) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (q.city ILIKE :search_term_8) THEN 1000 
                    WHEN (q.city ILIKE :search_term_suffix_8) THEN 100
                    WHEN (q.city ILIKE :search_term_prefix_8) THEN 80
                    WHEN (q.city ILIKE :search_term_both_8) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (u.email ILIKE :search_term_3) THEN 1000 
                    WHEN (u.email ILIKE :search_term_suffix_3) THEN 120
                    WHEN (u.email ILIKE :search_term_prefix_3) THEN 100
                    WHEN (u.email ILIKE :search_term_both_3) THEN 80
                    ELSE 0
                END ";
            $sql .= " AS weight ";
            $sql .= " FROM enduser u
            LEFT OUTER JOIN person p ON u.person_id = p.id
            LEFT OUTER JOIN place q on u.place_id = q.id ";
            $sql .= " WHERE ";
            if ($place !== null) {
                $sql .= " u.place_id = :place ";
                $data['place'] = $place;
                if ($person !== null) {
                    $sql .= " AND u.person_id = :person ";
                    $data['person'] = $person;
                }
                $sql .= " AND ";
            } elseif ($person !== null) {
                $sql .= " u.person_id = :person AND ";
                $data['person'] = $person;
            }
            if (!$show_inactive) {
                $sql .= " u.active = true AND ";
            }
            $sql .= " ((p.last_name ILIKE :search_term_w_1) OR
                (p.first_name ILIKE :search_term_w_2) OR
                (u.text ILIKE :search_term_w_4) OR
                (u.tel ILIKE :search_term_w_5) OR
                (u.mobile ILIKE :search_term_w_6) OR
                (q.name ILIKE :search_term_w_7) OR
                (q.city ILIKE :search_term_w_8) OR
                (u.email ILIKE :search_term_w_3)) ";
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
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql}, u.id LIMIT :per_page OFFSET :offset;";
            $data['per_page'] = $per_page;
            $data['offset'] = $offset;
            for ($i = 1; $i <= 8; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
            }
        }
        $ar = $this->getDbHelper()->querySelect($sql, $data);

        return array_values($ar);
    }

    /**
     * @param string|null $search_term
     * @param int|null $person
     * @param int|null $place
     * @param bool $show_inactive
     * @return int
     * @throws DatabaseError
     */
    public function count(
        ?string $search_term = null,
        ?int $person = null,
        ?int $place = null,
        bool $show_inactive = false
    ) : int {
        $sql = "SELECT COUNT(u.id), COUNT(u.id) as total FROM enduser u
            LEFT OUTER JOIN person p ON u.person_id = p.id
            LEFT OUTER JOIN place q on u.place_id = q.id ";
        $data = [];
        if ($search_term === null) {
            if ($place !== null) {
                $sql .= " WHERE u.place_id = :place ";
                $data['place'] = $place;
                if ($person !== null) {
                    $sql .= " AND u.person_id = :person ";
                    $data['person'] = $person;
                }
                if (!$show_inactive) {
                    $sql .= " AND u.active = true ";
                }
            } elseif ($person !== null) {
                $sql .= " WHERE u.person_id = :person ";
                $data['person'] = $person;
                if (!$show_inactive) {
                    $sql .= " AND u.active = true ";
                }
            } elseif (!$show_inactive) {
                $sql .= " WHERE u.active = true ";
            }
            $sql .= ";";
        } else {
            if ($place !== null) {
                $sql .= " WHERE u.place_id = :place ";
                $data['place'] = $place;
                if ($person !== null) {
                    $sql .= " AND u.person_id = :person ";
                    $data['person'] = $person;
                }
                $sql .= " AND ";
            } elseif ($person !== null) {
                $sql .= " WHERE u.person_id = :person AND ";
                $data['person'] = $person;
            } else {
                $sql .= " WHERE ";
            }
            if (!$show_inactive) {
                $sql .= " u.active = true AND ";
            }
            $sql .= "
                ((p.last_name ILIKE :search_term_w_1) OR
                (p.first_name ILIKE :search_term_w_2) OR
                (u.email ILIKE :search_term_w_3) OR
                (u.text ILIKE :search_term_w_4) OR
                (u.tel ILIKE :search_term_w_5) OR
                (u.mobile ILIKE :search_term_w_6) OR
                (q.name ILIKE :search_term_w_7) OR
                (q.city ILIKE :search_term_w_8)); ";
            for ($i = 1; $i <= 8; $i++) {
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
