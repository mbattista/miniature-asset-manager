<?php
declare(strict_types=1);

namespace AssetManager\Models;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\PlaceNotFoundException;
use AssetManager\Traits\DbHelperTrait;
use AssetManager\Traits\TimestampTrait;
use DateTime;

class Place
{
    use TimestampTrait;
    use DbHelperTrait;

    protected array $order_items = [
        'id' => 'a.id',
        'weight' => 'weight',
        'name' => 'a.name',
        'postcode' => 'a.postcode',
        'city' => 'a.city',
    ];
    protected array $sort_items = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    protected int $id;
    protected ?string $longitude;
    protected ?string $latitude;
    protected ?string $street;
    protected ?string $number;
    protected ?string $postcode;
    protected ?string $city;
    protected ?string $tel1;
    protected ?string $tel2;
    protected ?string $tel3;
    protected ?string $tel4;
    protected ?string $fax;
    protected ?string $opening_times;
    protected ?string $website;
    protected ?string $email;
    protected ?string $text;
    protected bool $active;
    protected bool $is_vvk;
    protected ?string $name;
    protected ?array $citrix;
    protected ?DateTime $last_changed;

    protected $return_array;

    public function __construct()
    {
        $this->id = 0;
        $this->longitude = null;
        $this->latitude = null;
        $this->street = null;
        $this->number = null;
        $this->postcode = null;
        $this->city = null;
        $this->tel1 = null;
        $this->tel2 = null;
        $this->tel3 = null;
        $this->tel4 = null;
        $this->fax = null;
        $this->opening_times = null;
        $this->website = null;
        $this->email = null;
        $this->text = null;
        $this->active = true;
        $this->name = null;
        $this->is_vvk = false;
        $this->citrix = null;
        $this->updated = null;
        $this->created = new DateTime('now');
        $this->last_changed = null;
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
     * @return Place
     */
    public function setId(int $id): Place
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     * @return Place
     */
    public function setLongitude(?string $longitude): Place
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * @param string|null $latitude
     * @return Place
     */
    public function setLatitude(?string $latitude): Place
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     * @return Place
     */
    public function setStreet(?string $street): Place
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     * @return Place
     */
    public function setNumber(?string $number): Place
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * @param string|null $postcode
     * @return Place
     */
    public function setPostcode(?string $postcode): Place
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return Place
     */
    public function setCity(?string $city): Place
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    /**
     * @param string|null $tel1
     * @return Place
     */
    public function setTel1(?string $tel1): Place
    {
        $this->tel1 = $tel1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    /**
     * @param string|null $tel2
     * @return Place
     */
    public function setTel2(?string $tel2): Place
    {
        $this->tel2 = $tel2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTel3(): ?string
    {
        return $this->tel3;
    }

    /**
     * @param string|null $tel3
     * @return Place
     */
    public function setTel3(?string $tel3): Place
    {
        $this->tel3 = $tel3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTel4(): ?string
    {
        return $this->tel4;
    }

    /**
     * @param string|null $tel4
     * @return Place
     */
    public function setTel4(?string $tel4): Place
    {
        $this->tel4 = $tel4;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFax(): ?string
    {
        return $this->fax;
    }

    /**
     * @param string|null $fax
     * @return Place
     */
    public function setFax(?string $fax): Place
    {
        $this->fax = $fax;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOpeningTimes(): ?string
    {
        return $this->opening_times;
    }

    /**
     * @param string|null $opening_times
     * @return Place
     */
    public function setOpeningTimes(?string $opening_times): Place
    {
        $this->opening_times = $opening_times;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $website
     * @return Place
     */
    public function setWebsite(?string $website): Place
    {
        $this->website = $website;
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
     * @return Place
     */
    public function setEmail(?string $email): Place
    {
        $this->email = $email;
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
     * @return Place
     */
    public function setText(?string $text): Place
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Place
     */
    public function setActive(bool $active): Place
    {
        $this->active = $active;
        return $this;
    }

    public function getActive(): string
    {
        return ($this->active ? 'true' : 'false');
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Place
     */
    public function setName(?string $name): Place
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsVvk(): bool
    {
        return $this->is_vvk;
    }

    /**
     * @param bool $is_vvk
     * @return Place
     */
    public function setIsVvk(bool $is_vvk): Place
    {
        $this->is_vvk = $is_vvk;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getCitrix(): ?array
    {
        return $this->citrix;
    }

    /**
     * @param array|null $citrix
     */
    public function setCitrix(?array $citrix): void
    {
        $this->citrix = $citrix;
    }

    /**
     * @return DateTime|null
     */
    public function getLastChanged(): ?DateTime
    {
        return $this->last_changed;
    }

    /**
     * @param DateTime|null $last_changed
     * @return Place
     */
    public function setLastChanged(?DateTime $last_changed): Place
    {
        $this->last_changed = $last_changed;
        return $this;
    }

    /**
     * @return bool
     * @throws DatabaseError
     */
    public function update()
    {
        $sql = "UPDATE place SET 
                    name = :name,
                    longitude = :longitude, 
                    latitude = :latitude, 
                    street = :street,
                    number = :number,
                    postcode = :postcode,
                    city = :city,
                    tel1 = :tel1,
                    tel2 = :tel2,
                    tel3 = :tel3,
                    tel4 = :tel4,
                    fax = :fax,
                    opening_times = :opening_times,
                    website = :website,
                    email = :email,
                    text = :text,
                    active = :active,
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'longitude' => $this->getLongitude(),
            'latitude' => $this->getLatitude(),
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'postcode' => $this->getPostcode(),
            'city' => $this->getCity(),
            'tel1' => $this->getTel1(),
            'tel2' => $this->getTel2(),
            'tel3' => $this->getTel3(),
            'tel4' => $this->getTel4(),
            'fax' => $this->getFax(),
            'opening_times' => $this->getOpeningTimes(),
            'website' => $this->getWebsite(),
            'email' => $this->getEmail(),
            'text' => $this->getText(),
            'active' => $this->getActive(),
        ];
        $return = $this->getDbHelper()->queryUpdate($sql, $data);

        $citrix_sql = " SELECT citrix_id, citrix_id FROM place_citrix WHERE place_id = :id ";
        $citrix_data = ['id' => $this->getId()];
        if ($this->getCitrix() !== null) {
            $citrix_places = $this->db_helper->querySelect($citrix_sql, $citrix_data);
            $data = [];
            $data_orig = [];
            foreach ($this->getCitrix() as $citrix) {
                if (isset($citrix['id'])) {
                    $data[] = $citrix['id'];
                } else {
                    $data[] = $citrix;
                }
            }
            foreach ($citrix_places as $citrix_place) {
                $data_orig[] = $citrix_place['citrix_id'];
            }
            $create = array_diff($data, $data_orig);
            $remove = array_diff($data_orig, $data);

            if (!empty($create)) {
                $sql_create_statement = " INSERT INTO place_citrix (place_id, citrix_id) VALUES ";
                foreach ($create as $key => $value) {
                    $sql_create_statement .= " ( :place_$key , :citrix_$key ) ,";
                    $sql_create_statement_data['place_' . $key] = $this->getId();
                    $sql_create_statement_data['citrix_' . $key] = $value;
                }
                $sql_create_statement = substr($sql_create_statement, 0, -1);
                $return = $this->db_helper->queryInsert($sql_create_statement, $sql_create_statement_data);
            }

            if (!empty($remove)) {
                foreach ($remove as $key => $value) {
                    $sql_remove_statement = " DELETE FROM place_citrix WHERE place_id =  :place AND citrix_id = :citrix ";
                    $sql_remove_statement_data = [ 'place' => $this->getId(), 'citrix' => $value ];
                    $return = $this->db_helper->queryDelete($sql_remove_statement, $sql_remove_statement_data);
                }
            }
        } else {
            $sql_remove_statement = " DELETE FROM place_citrix WHERE place_id = :place ";
            $sql_remove_statement_data = [ 'place' => $this->getId() ];
            $return = $this->db_helper->queryDelete($sql_remove_statement, $sql_remove_statement_data);
        }

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
        $sql = "INSERT INTO place (
                        name,
                        longitude,
                        latitude,
                        street,
                        number, 
                        postcode, 
                        city, 
                        tel1, 
                        tel2, 
                        tel3, 
                        tel4, 
                        fax, 
                        opening_times, 
                        website, 
                        email,
                        text, 
                        active ) "
            . " VALUES (
                        :name,
                        :longitude,
                        :latitude,
                        :street,
                        :number,
                        :postcode,
                        :city,
                        :tel1,
                        :tel2,
                        :tel3,
                        :tel4,
                        :fax,
                        :opening_times,
                        :website,
                        :email,
                        :text,
                        :active ) ";

        $data = [
            'name' => $this->getName(),
            'longitude' => $this->getLongitude(),
            'latitude' => $this->getLatitude(),
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'postcode' => $this->getPostcode(),
            'city' => $this->getCity(),
            'tel1' => $this->getTel1(),
            'tel2' => $this->getTel2(),
            'tel3' => $this->getTel3(),
            'tel4' => $this->getTel4(),
            'fax' => $this->getFax(),
            'opening_times' => $this->getOpeningTimes(),
            'website' => $this->getWebsite(),
            'email' => $this->getEmail(),
            'text' => $this->getText(),
            'active' => $this->getActive(),
        ];

        $return = $this->getDbHelper()->queryInsert($sql, $data);
        $this->setId((int)$return);

        if ($this->getCitrix() !== null) {
            $sql_create_statement = " INSERT INTO place_citrix (place_id, citrix_id) VALUES ";
            for ($i = 0; $i < count($this->getCitrix()); $i++) {
                $sql_create_statement .= " ( :place_$i , :citrix_$i ) ,";
                $sql_create_statement_data['place_' . $i] = $this->getId();
                $sql_create_statement_data['citrix_' . $i] = $this->getCitrix()[$i];
            }
            $sql_create_statement = substr($sql_create_statement, 0, -1);
            $returnab = $this->db_helper->queryInsert($sql_create_statement, $sql_create_statement_data);
        }

        return $return;
    }

    public function delete()
    {
        $data = [
            'id' => $this->getId(),
        ];
        $sql = "SELECT id, asset_id FROM places_assets WHERE place_id = :id AND until_datetimez = null;";
        $assets = $this->getDbHelper()->querySelect($sql, $data);
        $sql = "DELETE FROM places_assets WHERE place_id = :id;";
        $return = $this->getDbHelper()->queryDelete($sql, $data);
        $sql = "DELETE FROM enduser WHERE place_id = :id;";
        $return = $this->getDbHelper()->queryDelete($sql, $data);
        $sql = "DELETE FROM place_citrix WHERE place_id = :id;";
        $return = $this->getDbHelper()->queryDelete($sql, $data);
        $sql = "DELETE FROM place WHERE id = :id;";
        $return = $this->getDbHelper()->queryDelete($sql, $data);

        foreach ($assets as $asset) {
            $sql = "UPDATE places_assets SET until_datetimez = null WHERE asset_id = :asset_id AND id = (SELECT MAX(id) FROM places_assets WHERE asset_id = :asset_id_sub);";
            $data = [
                'asset_id' => $asset['asset_id'],
                'asset_id_sub' => $asset['asset_id'],
            ];
            $return = $this->getDbHelper()->queryUpdate($sql, $data);
        }

        if ($return === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @return $this
     * @throws PlaceNotFoundException
     * @throws DatabaseError
     */
    public function get(int $id)
    {
        $sql = "SELECT 
                    a.id,
                    a.id,
                    a.name,
                    a.longitude,
                    a.latitude,
                    a.street,
                    a.number,
                    a.postcode,
                    a.city,
                    a.tel1,
                    a.tel2,
                    a.tel3,
                    a.tel4,
                    a.fax,
                    a.opening_times,
                    a.website,
                    a.email,
                    a.text, 
                    a.active,
                    a.updated,
                    a.created
                FROM place a
                WHERE a.id = :id;";
        $data = [
            'id' => $id,
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (count($ar) === 0) {
            throw new PlaceNotFoundException();
        }
        $sql_citrix = " SELECT c.id, c.citrix_number FROM place_citrix pc JOIN citrix c ON pc.citrix_id = c.id WHERE place_id = :place; ";
        $sql_citrix_data = ['place' => $id];
        $citrixes = $this->getDbHelper()->querySelect($sql_citrix, $sql_citrix_data);
        if (!empty($citrixes)) {
            $this->setCitrix($citrixes);
        } else {
            $this->setCitrix(null);
        }
        $this->setId((int)array_key_first($ar));

        $ar = array_pop($ar);
        if (isset($ar['name'])) {
            $this->setName($ar['name']);
        }
        if (isset($ar['longitude'])) {
            $this->setLongitude($ar['longitude']);
        }
        if (isset($ar['latitude'])) {
            $this->setLatitude($ar['latitude']);
        }
        if (isset($ar['street'])) {
            $this->setStreet($ar['street']);
        }
        if (isset($ar['number'])) {
            $this->setNumber($ar['number']);
        }
        if (isset($ar['postcode'])) {
            $this->setPostcode($ar['postcode']);
        }
        if (isset($ar['city'])) {
            $this->setCity($ar['city']);
        }
        if (isset($ar['tel1'])) {
            $this->setTel1($ar['tel1']);
        }
        if (isset($ar['tel2'])) {
            $this->setTel2($ar['tel2']);
        }
        if (isset($ar['tel3'])) {
            $this->setTel3($ar['tel3']);
        }
        if (isset($ar['tel4'])) {
            $this->setTel4($ar['tel4']);
        }
        if (isset($ar['tel4'])) {
            $this->setTel4($ar['tel4']);
        }
        if (isset($ar['fax'])) {
            $this->setFax($ar['fax']);
        }
        if (isset($ar['opening_times'])) {
            $this->setOpeningTimes($ar['opening_times']);
        }
        if (isset($ar['website'])) {
            $this->setWebsite($ar['website']);
        }
        if (isset($ar['email'])) {
            $this->setEmail($ar['email']);
        }
        if (isset($ar['text'])) {
            $this->setText($ar['text']);
        }
        if (isset($ar['active'])) {
            $this->setActive((bool)$ar['active']);
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
        ?string $order_by = null,
        ?string $sort = null,
        bool $show_inactive = false
    ) {
        $sql = "SELECT
                    a.id,
                    a.id, 
                    a.name, 
                    a.longitude, 
                    a.latitude, 
                    a.street, 
                    a.number, 
                    a.postcode, 
                    a.city, 
                    a.tel1, 
                    a.tel2, 
                    a.tel3, 
                    a.tel4, 
                    a.fax, 
                    a.opening_times, 
                    a.website, 
                    a.email, 
                    a.text, 
                    a.active,
                    a.citrix ";
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
            $sql .= " FROM place_list_table a ";
            if (!$show_inactive) {
                $sql .= " WHERE a.active = true ";
            }
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset ";
            $data = [
                'offset' => $offset,
                'per_page' => $per_page,
            ];
        } else {
            $sql .= ", 
                CASE
                    WHEN (a.name ILIKE :search_term_1) THEN 1000
                    WHEN (a.name ILIKE :search_term_suffix_1) THEN 80
                    WHEN (a.name ILIKE :search_term_prefix_1) THEN 80
                    WHEN (a.name ILIKE :search_term_both_1) THEN 60
                    ELSE 0
                END 
                + CASE
                    WHEN (a.street ILIKE :search_term_2) THEN 1000
                    WHEN (a.street ILIKE :search_term_suffix_2) THEN 60
                    WHEN (a.street ILIKE :search_term_prefix_2) THEN 60
                    WHEN (a.street ILIKE :search_term_both_2) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (a.postcode ILIKE :search_term_3) THEN 1000
                    WHEN (a.postcode ILIKE :search_term_suffix_3) THEN 80
                    WHEN (a.postcode ILIKE :search_term_prefix_3) THEN 60
                    WHEN (a.postcode ILIKE :search_term_both_3) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.city ILIKE :search_term_4) THEN 1000
                    WHEN (a.city ILIKE :search_term_suffix_4) THEN 80
                    WHEN (a.city ILIKE :search_term_prefix_4) THEN 60
                    WHEN (a.city ILIKE :search_term_both_4) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (a.tel1 ILIKE :search_term_5) THEN 1000
                    WHEN (a.tel1 ILIKE :search_term_suffix_5) THEN 80
                    WHEN (a.tel1 ILIKE :search_term_prefix_5) THEN 60
                    WHEN (a.tel1 ILIKE :search_term_both_5) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.tel2 ILIKE :search_term_6) THEN 1000
                    WHEN (a.tel2 ILIKE :search_term_suffix_6) THEN 80
                    WHEN (a.tel2 ILIKE :search_term_prefix_6) THEN 60
                    WHEN (a.tel2 ILIKE :search_term_both_6) THEN 20
                    ELSE 0
                END 
                + CASE
                    WHEN (a.tel3 ILIKE :search_term_7) THEN 1000
                    WHEN (a.tel3 ILIKE :search_term_suffix_7) THEN 80
                    WHEN (a.tel3 ILIKE :search_term_prefix_7) THEN 60
                    WHEN (a.tel3 ILIKE :search_term_both_7) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.tel4 ILIKE :search_term_8) THEN 1000
                    WHEN (a.tel4 ILIKE :search_term_suffix_8) THEN 80
                    WHEN (a.tel4 ILIKE :search_term_prefix_8) THEN 60
                    WHEN (a.tel4 ILIKE :search_term_both_8) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.fax ILIKE :search_term_9) THEN 1000
                    WHEN (a.fax ILIKE :search_term_suffix_9) THEN 80
                    WHEN (a.fax ILIKE :search_term_prefix_9) THEN 60
                    WHEN (a.fax ILIKE :search_term_both_9) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.website ILIKE :search_term_10) THEN 1000
                    WHEN (a.website ILIKE :search_term_suffix_10) THEN 80
                    WHEN (a.website ILIKE :search_term_prefix_10) THEN 60
                    WHEN (a.website ILIKE :search_term_both_10) THEN 40
                    ELSE 0
                END
                + CASE 
                    WHEN (a.email ILIKE :search_term_11) THEN 1000
                    WHEN (a.email ILIKE :search_term_suffix_11) THEN 100
                    WHEN (a.email ILIKE :search_term_prefix_11) THEN 80
                    WHEN (a.email ILIKE :search_term_both_11) THEN 60
                    ELSE 0
                END 
                + CASE
                    WHEN (a.text ILIKE :search_term_12) THEN 1000
                    WHEN (a.text ILIKE :search_term_suffix_12) THEN 20
                    WHEN (a.text ILIKE :search_term_prefix_12) THEN 20
                    WHEN (a.text ILIKE :search_term_both_12) THEN 10
                    ELSE 0
                END
                + CASE
                    WHEN (a.citrix @> :search_term_json_1) THEN 1000
                    ELSE 0
                END ";
            $sql .= " AS weight ";
            $sql .= " FROM place_list_table a ";
            $sql .= " WHERE ((a.name ILIKE :search_term_w_1) 
                            OR (a.street ILIKE :search_term_w_2)
                            OR (a.postcode ILIKE :search_term_w_3) 
                            OR (a.city ILIKE :search_term_w_4) 
                            OR (a.tel1 ILIKE :search_term_w_5) 
                            OR (a.tel2 ILIKE :search_term_w_6) 
                            OR (a.tel3 ILIKE :search_term_w_7) 
                            OR (a.tel3 ILIKE :search_term_w_8) 
                            OR (a.fax ILIKE :search_term_w_9) 
                            OR (a.website ILIKE :search_term_w_10) 
                            OR (a.email ILIKE :search_term_w_11) 
                            OR (a.text ILIKE :search_term_w_12)
                            OR (a.citrix @> :search_term_json_w_1)
                            ) ";
            if (!$show_inactive) {
                $sql .= " AND a.active = true ";
            }
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
            for ($i = 1; $i <= 12; $i++) {
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
                $data['search_term_' . $i] = $search_term;
            }
            $data['search_term_json_w_1'] = '[{"citrix_number": "'. $search_term . '"}]';
            $data['search_term_json_1'] = '[{"citrix_number": "'. $search_term . '"}]';
        }
        $ar = $this->getDbHelper()->querySelect($sql, $data);

        if (!empty($ar)) {
            $end_user_sql = " SELECT
                                u.id,
                                u.id,
                                u.place_id,
                                u.tel,
                                u.mobile,
                                u.email,
                                p.last_name,
                                p.first_name
                              FROM enduser u
                              LEFT OUTER JOIN person p ON u.person_id = p.id
                              WHERE u.place_id IN (";
            foreach ($ar as $id => $item) {
                $end_user_sql .= " :place_id_{$id}, ";
                $end_user_data["place_id_{$id}"] = $id;
            }
            $end_user_sql = substr($end_user_sql, 0, -2);
            $end_user_sql .= ")";
            $end_user = $this->getDbHelper()->querySelect($end_user_sql, $end_user_data);
            foreach ($end_user as $item) {
                $place_id = $item['place_id'];
                unset($item['place_id']);
                $ar[$place_id]['end_user'][] = $item;
            }
        }

        $arr = array_map(function ($iteration) {
            $iteration['citrix'] = json_decode($iteration['citrix']);
            return $iteration;
        }, $ar);

        return array_values($arr);
    }

    /**
     * @param string|null $search_term
     * @param bool $show_inactive
     * @return int
     * @throws DatabaseError
     */
    public function count(?string $search_term = null, bool $show_inactive = false) : int
    {
        $sql = "SELECT COUNT(a.id), COUNT(a.id) as total FROM place_list_table a ";
        $data = [];
        if ($search_term === null) {
            if (!$show_inactive) {
                $sql .= " WHERE a.active = true ";
            }
            $sql .= ";";
        } else {
            $sql .= " WHERE ((a.name ILIKE :search_term_1) 
                            OR (a.street ILIKE :search_term_2) 
                            OR (a.postcode ILIKE :search_term_3) 
                            OR (a.city ILIKE :search_term_4) 
                            OR (a.tel1 ILIKE :search_term_5) 
                            OR (a.tel2 ILIKE :search_term_6) 
                            OR (a.tel3 ILIKE :search_term_7) 
                            OR (a.tel3 ILIKE :search_term_8) 
                            OR (a.fax ILIKE :search_term_9) 
                            OR (a.website ILIKE :search_term_10) 
                            OR (a.email ILIKE :search_term_11) 
                            OR (a.text ILIKE :search_term_12)
                            OR (a.citrix @> :search_term_json_1)) ";
            for ($i = 1; $i <= 12; $i++) {
                $data['search_term_' . $i] = '%' . $search_term . '%';
            }
            $data['search_term_json_1'] = '[{"citrix_number": "'. $search_term . '"}]';
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
        $array = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'longitude' => $this->getLongitude(),
            'latitude' => $this->getLatitude(),
            'street' => $this->getStreet(),
            'number' => $this->getNumber(),
            'postcode' => $this->getPostcode(),
            'city' => $this->getCity(),
            'tel1' => $this->getTel1(),
            'tel2' => $this->getTel2(),
            'tel3' => $this->getTel3(),
            'tel4' => $this->getTel4(),
            'fax' => $this->getFax(),
            'opening_times' => $this->getOpeningTimes(),
            'website' => $this->getWebsite(),
            'email' => $this->getEmail(),
            'text' => $this->getText(),
            'active' => $this->getActive(),
            'created' => $this->getCreated(),
            'updated' => $this->getUpdated(),
            'citrix' => $this->getCitrix(),
        ];

        return $array;
    }

    public function listDetailOverview(
        int $offset,
        int $per_page,
        ?string $search_term = null,
        ?string $order_by = null,
        ?string $sort = null,
        bool $show_inactive = false
    ) {
        $sql = "SELECT
                    a.id, 
                    a.id, 
                    a.name, 
                    a.longitude, 
                    a.latitude, 
                    a.street, 
                    a.number, 
                    a.postcode, 
                    a.city, 
                    a.tel1, 
                    a.tel2, 
                    a.tel3, 
                    a.tel4, 
                    a.fax, 
                    a.opening_times, 
                    a.website, 
                    a.email, 
                    a.text, 
                    a.last_changed,
                    a.active ";
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
            $sql .= " FROM place a ";
            if (!$show_inactive) {
                $sql .= " WHERE a.active = true ";
            }
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset ";
            $data = [
                'offset' => $offset,
                'per_page' => $per_page,
            ];
        } else {
            $sql .= ",
                CASE
                    WHEN (a.name ILIKE :search_term_1) THEN 1000
                    WHEN (a.name ILIKE :search_term_suffix_1) THEN 80
                    WHEN (a.name ILIKE :search_term_prefix_1) THEN 80
                    WHEN (a.name ILIKE :search_term_both_1) THEN 60
                    ELSE 0
                END 
                + CASE
                    WHEN (a.street ILIKE :search_term_2) THEN 1000
                    WHEN (a.street ILIKE :search_term_suffix_2) THEN 60
                    WHEN (a.street ILIKE :search_term_prefix_2) THEN 60
                    WHEN (a.street ILIKE :search_term_both_2) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (a.postcode ILIKE :search_term_3) THEN 1000
                    WHEN (a.postcode ILIKE :search_term_suffix_3) THEN 80
                    WHEN (a.postcode ILIKE :search_term_prefix_3) THEN 60
                    WHEN (a.postcode ILIKE :search_term_both_3) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.city ILIKE :search_term_4) THEN 1000
                    WHEN (a.city ILIKE :search_term_suffix_4) THEN 80
                    WHEN (a.city ILIKE :search_term_prefix_4) THEN 60
                    WHEN (a.city ILIKE :search_term_both_4) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (a.tel1 ILIKE :search_term_5) THEN 1000
                    WHEN (a.tel1 ILIKE :search_term_suffix_5) THEN 80
                    WHEN (a.tel1 ILIKE :search_term_prefix_5) THEN 60
                    WHEN (a.tel1 ILIKE :search_term_both_5) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.tel2 ILIKE :search_term_6) THEN 1000
                    WHEN (a.tel2 ILIKE :search_term_suffix_6) THEN 80
                    WHEN (a.tel2 ILIKE :search_term_prefix_6) THEN 60
                    WHEN (a.tel2 ILIKE :search_term_both_6) THEN 20
                    ELSE 0
                END 
                + CASE
                    WHEN (a.tel3 ILIKE :search_term_7) THEN 1000
                    WHEN (a.tel3 ILIKE :search_term_suffix_7) THEN 80
                    WHEN (a.tel3 ILIKE :search_term_prefix_7) THEN 60
                    WHEN (a.tel3 ILIKE :search_term_both_7) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.tel4 ILIKE :search_term_8) THEN 1000
                    WHEN (a.tel4 ILIKE :search_term_suffix_8) THEN 80
                    WHEN (a.tel4 ILIKE :search_term_prefix_8) THEN 60
                    WHEN (a.tel4 ILIKE :search_term_both_8) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.fax ILIKE :search_term_9) THEN 1000
                    WHEN (a.fax ILIKE :search_term_suffix_9) THEN 80
                    WHEN (a.fax ILIKE :search_term_prefix_9) THEN 60
                    WHEN (a.fax ILIKE :search_term_both_9) THEN 20
                    ELSE 0
                END
                + CASE
                    WHEN (a.website ILIKE :search_term_10) THEN 1000
                    WHEN (a.website ILIKE :search_term_suffix_10) THEN 80
                    WHEN (a.website ILIKE :search_term_prefix_10) THEN 60
                    WHEN (a.website ILIKE :search_term_both_10) THEN 40
                    ELSE 0
                END
                + CASE 
                    WHEN (a.email ILIKE :search_term_11) THEN 1000
                    WHEN (a.email ILIKE :search_term_suffix_11) THEN 100
                    WHEN (a.email ILIKE :search_term_prefix_11) THEN 80
                    WHEN (a.email ILIKE :search_term_both_11) THEN 60
                    ELSE 0
                END 
                + CASE
                    WHEN (a.text ILIKE :search_term_12) THEN 1000
                    WHEN (a.text ILIKE :search_term_suffix_12) THEN 20
                    WHEN (a.text ILIKE :search_term_prefix_12) THEN 20
                    WHEN (a.text ILIKE :search_term_both_12) THEN 10
                    ELSE 0
                END ";
            $sql .= " AS weight ";
            $sql .= " FROM place a ";
            $sql .= " WHERE ((a.name ILIKE :search_term_w_1) 
                            OR (a.street ILIKE :search_term_w_2)
                            OR (a.postcode ILIKE :search_term_w_3) 
                            OR (a.city ILIKE :search_term_w_4) 
                            OR (a.tel1 ILIKE :search_term_w_5) 
                            OR (a.tel2 ILIKE :search_term_w_6) 
                            OR (a.tel3 ILIKE :search_term_w_7) 
                            OR (a.tel3 ILIKE :search_term_w_8) 
                            OR (a.fax ILIKE :search_term_w_9) 
                            OR (a.website ILIKE :search_term_w_10) 
                            OR (a.email ILIKE :search_term_w_11) 
                            OR (a.text ILIKE :search_term_w_12)) ";
            if (!$show_inactive) {
                $sql .= " AND a.active = true ";
            }
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
            for ($i = 1; $i <= 12; $i++) {
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
                $data['search_term_' . $i] = $search_term;
            }
        }
        $ar = $this->getDbHelper()->querySelect($sql, $data);

        foreach ($ar as $id => $place) {
            $citrix_sql = " SELECT 
                            c.id,
                            c.id,
                            c.citrix_number,
                            c.show_id,
                            p.id as place_id
                        FROM citrix c
                        JOIN place_citrix pa ON c.id = pa.citrix_id
                        JOIN place p ON p.id = pa.place_id
                        WHERE p.id = :place_id
                        LIMIT 1000; ";
            $citrix_data["place_id"] = $id;
            $citrix = $this->getDbHelper()->querySelect($citrix_sql, $citrix_data);

            foreach ($citrix as $item) {
                $place_id = $item['place_id'];
                unset($item['place_id']);
                $ar[$place_id]['citrix'][] = $item;
            }

            $asset_sql = " SELECT 
                            a.id,
                            a.id,
                            a.name,
                            a.serial,
                            a.type,
                            a.active,
                            a.out_of_order,
                            a.citrix,
                            a.place_id,
                            a.from_datetimez
                        FROM asset_list_table a
                        WHERE a.place_id = :place_id
                        ORDER BY a.from_datetimez DESC
                        LIMIT 1000; ";
            $asset_data["place_id"] = $id;
            $assets = $this->getDbHelper()->querySelect($asset_sql, $asset_data);

            foreach ($assets as $asset) {
                if (isset($asset['citrix'])) {
                    $citrix = json_decode($asset['citrix'], true);
                    $asset['citrix'] = $citrix;
                    foreach ($citrix as $item) {
                        $citrix_item = [
                            'id' => $item['id'],
                            'citrix_number' => $item['citrix_number'],
                            'show_id' => $item['show_id'],
                        ];
                        if (!isset($ar[$id]['citrix'])) {
                            $ar[$id]['citrix'][] = $citrix_item;
                        } elseif (array_search($item['citrix_number'], array_column($ar[$id]['citrix'], 'citrix_number')) === false) {
                            $ar[$id]['citrix'][] = $citrix_item;
                        }
                    }
                }
                $place_id = $asset['place_id'];
                unset($asset['place_id']);
                if (!isset($ar[$place_id]['asset'][$asset['id']])) {
                    $ar[$place_id]['asset'][$asset['id']] = $asset;
                }
            }
            if (!empty($ar)) {
                foreach ($ar as $key => $it) {
                    if (isset($ar[$key]['asset'])) {
                        $ar[$key]['asset'] = array_values($ar[$key]['asset']);
                    }
                }
            }
        }

        return $ar;
    }

    public function countDetailOverview(?string $search_term = null, bool $show_inactive = false) : int
    {
        $sql = "SELECT COUNT(a.id), COUNT(a.id) as total FROM place a ";
        $data = [];
        if ($search_term === null) {
            if (!$show_inactive) {
                $sql .= " WHERE a.active = true ";
            }
            $sql .= ";";
        } else {
            $sql .= " WHERE ((a.name ILIKE :search_term_1) 
                            OR (a.street ILIKE :search_term_2) 
                            OR (a.postcode ILIKE :search_term_3) 
                            OR (a.city ILIKE :search_term_4) 
                            OR (a.tel1 ILIKE :search_term_5) 
                            OR (a.tel2 ILIKE :search_term_6) 
                            OR (a.tel3 ILIKE :search_term_7) 
                            OR (a.tel3 ILIKE :search_term_8) 
                            OR (a.fax ILIKE :search_term_9) 
                            OR (a.website ILIKE :search_term_10) 
                            OR (a.email ILIKE :search_term_11) 
                            OR (a.text ILIKE :search_term_12)) ";
            for ($i = 1; $i <= 12; $i++) {
                $data['search_term_' . $i] = '%' . $search_term . '%';
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

    /**
     * @param int $id
     * @return bool
     * @throws DatabaseError
     */
    public function updateLastChanged(int $id)
    {
        $sql = " UPDATE place SET last_changed = now() WHERE id = :id ";
        $data = [
            'id' => $id
        ];
        $this->getDbHelper()->queryUpdate($sql, $data);

        return true;
    }
}
