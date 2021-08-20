<?php
declare(strict_types=1);

namespace AssetManager\Models;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\InvalidPasswordException;
use AssetManager\Error\UserNotFoundException;
use AssetManager\Traits\DbHelperTrait;
use AssetManager\Traits\TimestampTrait;
use DateTime;

class User
{
    use DbHelperTrait;
    use TimestampTrait;

    protected array $order_items = [
        'id' => 'u.id',
        'weight' => 'weight',
        'last_name' => 'p.last_name',
        'nickname' => 'u.nickname',
        'email' => 'u.email',
    ];
    protected array $sort_items = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    protected array $return_array = [];

    protected int $id;
    protected int $person;
    protected string $nickname;
    protected ?string $email;
    protected string $password;
    protected ?string $first_name;
    protected ?string $last_name;
    protected ?DateTime $last_login;
    protected bool $deactivated;
    protected ?array $acl_groups;
    protected ?string $api_token;
    protected ?int $per_page_preference;

    public function __construct()
    {
        $this->id = 0;
        $this->person = 0;
        $this->per_page_preference = null;
        $this->email = '';
        $this->nickname = '';
        $this->password = '';
        $this->last_name = '';
        $this->first_name = '';
        $this->last_login = new DateTime();
        $this->deactivated = false;
        $this->api_token = null;
        $this->acl_groups = [];
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
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPerson(): int
    {
        return $this->person;
    }

    /**
     * @param int $person
     * @return User
     */
    public function setPerson(int $person): User
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     * @return User
     */
    public function setNickname(string $nickname): User
    {
        $this->nickname = $nickname;
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
     * @param ?string $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     * @throws InvalidPasswordException
     */
    public function setPassword(string $password): User
    {
        $pass = password_hash($password, PASSWORD_DEFAULT);
        if ($pass !== false && $pass !== null) {
            $this->password = $pass;
        } else {
            throw new invalidPasswordException;
        }

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getLastLogin(): ?DateTime
    {
        return $this->last_login;
    }

    /**
     * @param DateTime|null $last_login
     * @return User
     */
    public function setLastLogin(?DateTime $last_login): User
    {
        $this->last_login = $last_login;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeactivated(): bool
    {
        return $this->deactivated;
    }

    /**
     * @param bool $deactivated
     * @return User
     */
    public function setDeactivated(bool $deactivated): User
    {
        $this->deactivated = $deactivated;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiToken(): ?string
    {
        return $this->api_token;
    }

    /**
     * @param string|null $api_token
     * @return User
     */
    public function setApiToken(?string $api_token): User
    {
        $this->api_token = $api_token;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerPagePreference(): ?int
    {
        return $this->per_page_preference;
    }

    /**
     * @param int|null $per_page_preference
     * @return User
     */
    public function setPerPagePreference(?int $per_page_preference): User
    {
        $this->per_page_preference = $per_page_preference;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAclGroups(): ?array
    {
        return $this->acl_groups;
    }

    /**
     * @param array|null $acl_groups
     * @return User
     */
    public function setAclGroups(?array $acl_groups): User
    {
        $this->acl_groups = $acl_groups;
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
        $sql = "UPDATE asset_user SET 
                    person_id = :person,
                    nickname = :nickname, 
                    email = :email,
                    password = :password,
                    deactivated = :deactivated, 
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'person' => $this->getPerson(),
            'nickname' => $this->getNickname(),
            'password' => $this->getPassword(),
            'email' => $this->getEmail(),
            'deactivated' => ($this->isDeactivated() ? 'true' : 'false'),
        ];
        $return = $this->getDbHelper()->queryUpdate($sql, $data);
        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @throws DatabaseError
     */
    public function updatePreferences(): bool
    {
        $sql = " UPDATE asset_user SET
                    per_page_preference = :per_page_preference,
                    updated = NOW()
                 WHERE id = :id; ";
        $data = [
            'id' => $this->getId(),
            'per_page_preference' => $this->getPerPagePreference(),
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
        $sql = "INSERT INTO asset_user (person_id, nickname, email, password, deactivated) VALUES (:person, :nickname, :email, :password, :deactivated)";

        $data = [
            'person' => $this->getPerson(),
            'email' => $this->getEmail(),
            'nickname' => $this->getNickname(),
            'password' => $this->getPassword(),
            'deactivated' => ($this->isDeactivated() ? 'true' : 'false'),
        ];

        $return = $this->getDbHelper()->queryInsert($sql, $data);
        return $return;
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM asset_user WHERE id = ?;";
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
    public function get(int $id): User
    {
        $sql = "SELECT 
                    u.id,
                    u.id,
                    u.person_id, 
                    u.email, 
                    u.created, 
                    u.updated,
                    u.nickname,
                    u.per_page_preference, 
                    p.last_name, 
                    p.first_name, 
                    u.last_login, 
                    u.api_token 
                FROM asset_user u 
                LEFT OUTER JOIN person p ON u.person_id = p.id 
                WHERE u.id = :id;";
        $data = [
            'id' => $id,
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (count($ar) === 0) {
            throw new UserNotFoundException();
        }

        $this->setId((int)array_key_first($ar));
        $this->return_array['id'] = (int)array_key_first($ar);
        $ar = array_pop($ar);
        if (isset($ar['person_id'])) {
            $this->setPerson($ar['person_id']);
            $this->return_array['person'] = $ar['person_id'];
        }
        if (isset($ar['nickname'])) {
            $this->setNickname($ar['nickname']);
            $this->return_array['nickname'] = $ar['nickname'];
        }
        if (isset($ar['email'])) {
            $this->setEmail($ar['email']);
            $this->return_array['email'] = $ar['email'];
        }
        if (isset($ar['per_page_preference'])) {
            $this->setPerPagePreference($ar['per_page_preference']);
            $this->return_array['per_page_preference'] = $ar['per_page_preference'];
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
        if (isset($ar['deactivated'])) {
            $this->setDeactivated((bool)$ar['deactivated']);
            $this->return_array['deactivated'] = $ar['deactivated'];
        }
        if (isset($ar['last_login'])) {
            $this->setLastLogin(new DateTime($ar['last_login']));
            $this->return_array['last_login'] = new DateTime($ar['last_login']);
        }
        if (isset($ar['first_name'])) {
            $this->setFirstName($ar['first_name']);
            $this->return_array['first_name'] = $ar['first_name'];
        }
        if (isset($ar['last_name'])) {
            $this->setFirstName($ar['last_name']);
            $this->return_array['last_name'] = $ar['last_name'];
        }
        if (isset($ar['api_token'])) {
            $this->setApiToken($ar['api_token']);
        }

        return $this;
    }

    /**
     * @param int $offset
     * @param int $per_page
     * @param string|null $search_term
     * @param string|null $order_by
     * @param string|null $sort
     * @return array
     * @throws DatabaseError
     */
    public function lists(
        int $offset,
        int $per_page,
        ?string $search_term = null,
        ?string $order_by = null,
        ?string $sort = null
    ): array {
        $sql = "SELECT 
                    u.id,
                    u.id,
                    u.person_id,
                    u.nickname,
                    u.email,
                    u.created,
                    u.updated,
                    p.last_name,
                    p.first_name,
                    u.last_login ";
        if ($search_term === null) {
            $sql .= " 
                FROM asset_user u 
                LEFT OUTER JOIN person p ON u.person_id = p.id ";

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
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
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
                    WHEN (u.email ILIKE :search_term_3) THEN 1000 
                    WHEN (u.email ILIKE :search_term_suffix_3) THEN 100
                    WHEN (u.email ILIKE :search_term_prefix_3) THEN 80
                    WHEN (u.email ILIKE :search_term_both_3) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (u.nickname ILIKE :search_term_4) THEN 1000 
                    WHEN (u.nickname ILIKE :search_term_suffix_4) THEN 100
                    WHEN (u.nickname ILIKE :search_term_prefix_4) THEN 80
                    WHEN (u.nickname ILIKE :search_term_both_4) THEN 40
                    ELSE 0
                END ";
            $sql .= " AS weight ";
            $sql .= " FROM asset_user u LEFT OUTER JOIN person p ON u.person_id = p.id ";
            $sql .= " WHERE (p.last_name ILIKE :search_term_w_1) OR (p.first_name ILIKE :search_term_w_2) OR (u.email ILIKE :search_term_w_3) OR (u.nickname ILIKE :search_term_w_4) ";
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
            $data = [
                'offset' => $offset,
                'per_page' => $per_page,
            ];
            for ($i = 1; $i <= 4; $i++) {
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
     * @return int
     * @throws DatabaseError
     */
    public function count(?string $search_term = null) : int
    {
        $sql = "SELECT COUNT(u.id), COUNT(u.id) AS total 
                FROM asset_user u
                LEFT OUTER JOIN person p ON u.person_id = p.id ";
        $data = [];
        if ($search_term === null) {
            $sql .= ";";
        } else {
            $sql .= " WHERE (p.last_name ILIKE :search_term_w_1) OR (p.first_name ILIKE :search_term_w_2) OR (u.email ILIKE :search_term_w_3) OR (u.nickname ILIKE :search_term_w_4) ";
            for ($i = 1; $i <= 4; $i++) {
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

    public function changePassword(): bool
    {
        $sql = "UPDATE asset_user SET 
                    password = :password,
                    password_reset_hash = NULL, 
                    password_reset_date = NULL, 
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'password' => $this->getPassword(),
        ];
        $return = $this->getDbHelper()->queryUpdate($sql, $data);
        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @throws DatabaseError
     */
    public function resetPassword(): bool
    {
        $sql = "UPDATE asset_user SET 
                    password_reset_hash = :reset_password, 
                    password_reset_date = NOW(),
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'reset_password' => bin2hex(random_bytes(16)),
        ];
        $return = $this->getDbHelper()->queryUpdate($sql, $data);
        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @return int
     * @throws DatabaseError|UserNotFoundException
     */
    public function authorize(string $email, string $password): int
    {
        $sql = "SELECT u.id, u.id, u.password FROM asset_user u WHERE u.email = :email OR u.nickname = :nickname ;";
        $data = [
            'email' => $email,
            'nickname' => $email,
        ];

        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (empty($ar)) {
            throw new UserNotFoundException();
        }
        $ar = array_pop($ar);

        if (password_verify($password, $ar['password'])) {
            return $ar['id'];
        }

        throw new UserNotFoundException();
    }

    /**
     * @param string $token
     * @return int
     * @throws DatabaseError
     */
    public function authorizeToken(string $token): int
    {
        $sql = "SELECT u.id, u.api_token FROM asset_user u WHERE u.api_token  = :token AND u.api_token_valid_until > NOW() ;";
        $data = [
            'token' => $token,
        ];

        $ar = $this->getDbHelper()->querySelect($sql, $data);

        if (!empty($ar)) {
            return array_key_first($ar);
        }

        return 0;
    }

    /**
     * @return string
     * @throws DatabaseError
     */
    public function createToken(): string
    {
        $token = bin2hex(random_bytes(32));
        $sql = "UPDATE asset_user SET api_token = :token, last_login = NOW(), api_token_valid_until = NOW() + INTERVAL '1' HOUR WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'token' => $token,
        ];
        $result = $this->getDbHelper()->queryUpdate($sql, $data);

        if ($result > 0) {
            return $token;
        } else {
            throw new DatabaseError();
        }
    }

    /**
     * @return bool
     * @throws DatabaseError
     */
    public function updateToken(): bool
    {
        $sql = "UPDATE asset_user SET last_login = NOW(), api_token_valid_until = NOW() + INTERVAL '1' HOUR WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
        ];
        $result = $this->getDbHelper()->queryUpdate($sql, $data);

        return $result > 0;
    }

    /**
     * @return string
     * @throws DatabaseError
     */
    public function deleteToken(): bool
    {
        $token = bin2hex(random_bytes(32));
        $sql = "UPDATE asset_user SET api_token = null, last_login = NOW(), api_token_valid_until = null WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
        ];
        $result = $this->getDbHelper()->queryUpdate($sql, $data);

        if ($result > 0) {
            return true;
        } else {
            throw new DatabaseError();
        }
    }

    public function checkAdmin(): bool
    {
        $sql = "SELECT id, is_admin FROM asset_user WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        $ar = array_pop($ar);

        if (!empty($ar)) {
            return $ar['is_admin'];
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     * @return User
     */
    public function setFirstName(?string $first_name): User
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     * @return User
     */
    public function setLastName(?string $last_name): User
    {
        $this->last_name = $last_name;
        return $this;
    }
}
