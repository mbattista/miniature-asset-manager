<?php
declare(strict_types=1);

namespace AssetManager\Models;

use AssetManager\Error\AssetNotFoundException;
use AssetManager\Error\DatabaseError;
use AssetManager\Traits\DbHelperTrait;
use AssetManager\Traits\TimestampTrait;
use DateTime;

class Asset
{
    use TimestampTrait;
    use DbHelperTrait;

    protected array $order_items = [
        'name' => 'a.name',
        'id' => 'a.id',
        'weight' => 'weight',
        'type' => 'a.type',
        'serial' => 'a.serial',
        'out_of_order' => 'a.out_of_order',
        'is_loan' => 'a.is_loan',
        'citrix' => 'c.citrix_number',
        'from' => 'a.from_datetimez',
    ];
    protected array $sort_items = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    protected int $id;
    protected ?string $serial;
    protected ?bool $active;
    protected ?string $name;
    protected ?string $type;
    protected ?bool $out_of_order;
    protected ?string $text;
    protected ?bool $is_loan;
    protected ?string $teamviewer_string;
    protected ?array $citrix;
    protected ?bool $dhcp;
    protected ?string $ip;
    protected ?string $subnet;
    protected ?string $dns1;
    protected ?string $dns2;
    protected ?string $gateway;

    protected array $return_array = [];

    public function __construct()
    {
        $this->id = 0;
        $this->serial = null;
        $this->active = null;
        $this->name = null;
        $this->type = null;
        $this->out_of_order = null;
        $this->text = null;
        $this->is_loan = null;
        $this->teamviewer_string = null;
        $this->citrix = null;
        $this->created = new DateTime('now');
        $this->updated = null;
        $this->dhcp = null;
        $this->subnet = null;
        $this->ip = null;
        $this->dns1 = null;
        $this->dns2 = null;
        $this->gateway = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Asset
    {
        $this->id = $id;
        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): Asset
    {
        $this->serial = $serial;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     * @return $this
     */
    public function setActive(?bool $active): Asset
    {
        $this->active = $active;
        return $this;
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
     * @return $this
     */
    public function setName(?string $name): Asset
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type): Asset
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isOutOfOrder(): ?bool
    {
        return $this->out_of_order;
    }

    /**
     * @param bool|null $out_of_order
     * @return $this
     */
    public function setOutOfOrder(?bool $out_of_order): Asset
    {
        $this->out_of_order = $out_of_order;
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
     * @return $this
     */
    public function setText(?string $text): Asset
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsLoan(): ?string
    {
        if ($this->is_loan) {
            return 'true';
        }
        return 'false';
    }

    /**
     * @return bool|null
     */
    public function isIsLoan(): ?bool
    {
        return $this->is_loan;
    }

    /**
     * @param bool|null $is_loan
     * @return Asset
     */
    public function setIsLoan(?bool $is_loan): Asset
    {
        $this->is_loan = $is_loan;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getActive(): ?string
    {
        if ($this->active === null) {
            return null;
        }
        return ($this->active ? 'true' : 'false');
    }

    /**
     * @return string|null
     */
    public function getOutOfOrder(): ?string
    {
        if ($this->out_of_order === null) {
            return null;
        }
        return ($this->out_of_order ? 'true' : 'false');
    }

    /**
     * @return string|null
     */
    public function getTeamviewerId(): ?string
    {
        return $this->teamviewer_string;
    }

    /**
     * @param string|null $teamviewer_string
     * @return Asset
     */
    public function setTeamviewerId(?string $teamviewer_string): Asset
    {
        $this->teamviewer_string = $teamviewer_string;
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
     * @return Asset
     */
    public function setCitrix(?array $citrix): Asset
    {
        $this->citrix = $citrix;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isDhcp(): ?bool
    {
        return $this->dhcp;
    }

    public function getDhcp(): ?string
    {
        if ($this->dhcp === true) {
            return 'true';
        } elseif ($this->dhcp === false) {
            return 'false';
        } else {
            return null;
        }
    }

    /**
     * @param bool|null $dhcp
     */
    public function setDhcp(?bool $dhcp): void
    {
        $this->dhcp = $dhcp;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     */
    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string|null
     */
    public function getSubnet(): ?string
    {
        return $this->subnet;
    }

    /**
     * @param string|null $subnet
     */
    public function setSubnet(?string $subnet): void
    {
        $this->subnet = $subnet;
    }

    /**
     * @return string|null
     */
    public function getDns1(): ?string
    {
        return $this->dns1;
    }

    /**
     * @param string|null $dns1
     */
    public function setDns1(?string $dns1): void
    {
        $this->dns1 = $dns1;
    }

    /**
     * @return string|null
     */
    public function getDns2(): ?string
    {
        return $this->dns2;
    }

    /**
     * @param string|null $dns2
     */
    public function setDns2(?string $dns2): void
    {
        $this->dns2 = $dns2;
    }

    /**
     * @return string|null
     */
    public function getGateway(): ?string
    {
        return $this->gateway;
    }

    /**
     * @param string|null $gateway
     */
    public function setGateway(?string $gateway): void
    {
        $this->gateway = $gateway;
    }

    /**
     * @return bool
     * @throws DatabaseError
     */
    public function update()
    {
        $sql = "UPDATE asset SET 
                    serial = :serial, 
                    active = :active, 
                    name = :name,
                    type = :type,
                    out_of_order = :out_of_order,
                    is_loan = :is_loan,
                    teamviewer_string = :teamviewer_string,
                    dhcp = :dhcp,
                    ip = :ip,
                    subnet = :subnet,
                    dns1 = :dns1,
                    dns2 = :dns2,
                    gateway = :gateway,
                    text = :text,
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'serial' => $this->getSerial(),
            'active' => $this->getActive(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'out_of_order' => $this->getOutOfOrder(),
            'is_loan' => $this->getIsLoan(),
            'teamviewer_string' => $this->getTeamviewerId(),
            'dhcp' => $this->getDhcp(),
            'ip' => $this->getIp(),
            'subnet' => $this->getSubnet(),
            'dns1' => $this->getDns1(),
            'dns2' => $this->getDns2(),
            'gateway' => $this->getGateway(),
            'text' => $this->getText()
        ];
        $return = $this->getDbHelper()->queryUpdate($sql, $data);
        if ($return === 1) {
            $citrix_sql = " SELECT citrix_id, citrix_id FROM asset_citrix WHERE asset_id = :id AND until IS NULL ";
            $citrix_data = [ 'id' => $this->getId() ];
            if ($this->getCitrix() !== null) {
                $citrix_assets = $this->db_helper->querySelect($citrix_sql, $citrix_data);
                $data = [];
                $data_orig = [];
                foreach ($this->getCitrix() as $citrix) {
                    if (isset($citrix['id'])) {
                        $data[] = $citrix['id'];
                    } else {
                        $data[] = $citrix;
                    }
                }
                foreach ($citrix_assets as $citrix_asset) {
                    $data_orig[] = $citrix_asset['citrix_id'];
                }
                $create = array_diff($data, $data_orig);
                $remove = array_diff($data_orig, $data);

                if (!empty($create)) {
                    $sql_create_statement = " INSERT INTO asset_citrix (asset_id, citrix_id, from_date) VALUES ";
                    foreach ($create as $key => $value) {
                        $sql_create_statement .= " ( :asset_$key , :citrix_$key, NOW() ) ,";
                        $sql_create_statement_data['asset_' . $key] = $this->getId();
                        $sql_create_statement_data['citrix_' . $key] = $value;
                    }
                    $sql_create_statement = substr($sql_create_statement, 0, -1);
                    $return = $this->db_helper->queryInsert($sql_create_statement, $sql_create_statement_data);
                }

                if (!empty($remove)) {
                    foreach ($remove as $key => $value) {
                        $sql_remove_statement = " UPDATE asset_citrix SET until = NOW() WHERE asset_id =  :asset AND citrix_id = :citrix ";
                        $sql_remove_statement_data = [ 'asset' => $this->getId(), 'citrix' => $value ];
                        $return = $this->db_helper->queryUpdate($sql_remove_statement, $sql_remove_statement_data);
                    }
                }
            } else {
                $sql_remove_statement = " UPDATE asset_citrix SET until = NOW() WHERE asset_id = :asset ";
                $sql_remove_statement_data = [ 'asset' => $this->getId() ];
                $return = $this->db_helper->queryUpdate($sql_remove_statement, $sql_remove_statement_data);
            }

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
        $sql = "INSERT INTO asset (
                        serial,
                        active,
                        name,
                        type,
                        out_of_order,
                        is_loan,
                        text,
                        teamviewer_string,
                        dhcp,
                        subnet,
                        ip,
                        dns1,
                        dns2,
                        gateway
                    ) VALUES (
                        :serial,
                        :active,
                        :name,
                        :type,
                        :out_of_order,
                        :is_loan,
                        :text,
                        :teamviewer_string,
                        :dhcp,
                        :subnet,
                        :ip,
                        :dns1,
                        :dns2,
                        :gateway
                        )";

        $data = [
            'serial' => $this->getSerial(),
            'active' => $this->getActive(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'out_of_order' => $this->getOutOfOrder(),
            'is_loan' => $this->getIsLoan(),
            'teamviewer_string' => $this->getTeamviewerId(),
            'dhcp' => $this->getDhcp(),
            'subnet' => $this->getSubnet(),
            'ip' => $this->getIp(),
            'dns1' => $this->getDns1(),
            'dns2' => $this->getDns2(),
            'gateway' => $this->getGateway(),
            'text' => $this->getText(),
        ];

        $return = $this->getDbHelper()->queryInsert($sql, $data);

        if ($this->getCitrix() !== null) {
            $citrix_sql = " INSERT INTO asset_citrix (asset_id, citrix_id, from_date) VALUES (:asset_id, :citrix_id, NOW()); ";
            foreach ($this->getCitrix() as $citrix) {
                $citrix_data = [
                    'citrix_id' => $citrix,
                    'asset_id' => $return,
                ];
                $this->getDbHelper()->queryInsert($citrix_sql, $citrix_data);
            }
        }

        return $return;
    }

    public function delete()
    {
        $data = [
            $this->getId(),
        ];
        $sql = "DELETE FROM asset_citrix WHERE asset_id = ?;";
        $return = $this->getDbHelper()->queryDelete($sql, $data);
        $sql = "DELETE FROM places_assets WHERE asset_id = ?;";
        $return = $this->getDbHelper()->queryDelete($sql, $data);
        $sql = "DELETE FROM asset WHERE id = ?;";
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
     * @throws AssetNotFoundException
     * @throws DatabaseError
     */
    public function get(int $id)
    {
        $sql = "SELECT
                    a.id,
                    a.id,
                    a.serial,
                    a.active,
                    a.name,
                    a.type,
                    a.out_of_order,
                    a.is_loan,
                    a.text,
                    a.teamviewer_string,
                    a.dhcp,
                    a.ip,
                    a.subnet,
                    a.dns1,
                    a.dns2,
                    a.gateway,
                    a.created,
                    a.updated
                FROM asset a 
                WHERE a.id = :id;";
        $data = [
            'id' => $id
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (count($ar) === 0) {
            throw new AssetNotFoundException();
        }

        $this->setId((int)array_key_first($ar));
        $this->return_array['id'] = array_key_first($ar);

        $ar = array_pop($ar);
        if (isset($ar['serial'])) {
            $this->setSerial($ar['serial']);
            $this->return_array['serial'] = $ar['serial'];
        }
        if (isset($ar['active'])) {
            $this->setActive((bool)$ar['active']);
            $this->return_array['active'] = $ar['active'];
        }
        if (isset($ar['name'])) {
            $this->setName($ar['name']);
            $this->return_array['name'] = $ar['name'];
        }
        if (isset($ar['type'])) {
            $this->setType($ar['type']);
            $this->return_array['type'] = $ar['type'];
        }
        if (isset($ar['out_of_order'])) {
            $this->setOutOfOrder((bool)$ar['out_of_order']);
            $this->return_array['out_of_order'] = $ar['out_of_order'];
        }
        if (isset($ar['is_loan'])) {
            $this->setIsLoan($ar['is_loan']);
            $this->return_array['is_loan'] = $ar['is_loan'];
        }
        if (isset($ar['teamviewer_string'])) {
            $this->setTeamviewerId($ar['teamviewer_string']);
            $this->return_array['teamviewer_string'] = $ar['teamviewer_string'];
        }
        if (isset($ar['dhcp'])) {
            $this->setDhcp($ar['dhcp']);
            $this->return_array['dhcp'] = $ar['dhcp'];
        }
        if (isset($ar['ip'])) {
            $this->setIp($ar['ip']);
            $this->return_array['ip'] = $ar['ip'];
        }
        if (isset($ar['subnet'])) {
            $this->setSubnet($ar['subnet']);
            $this->return_array['subnet'] = $ar['subnet'];
        }
        if (isset($ar['dns1'])) {
            $this->setDns1($ar['dns1']);
            $this->return_array['dns1'] = $ar['dns1'];
        }
        if (isset($ar['dns2'])) {
            $this->setDns2($ar['dns2']);
            $this->return_array['dns2'] = $ar['dns2'];
        }
        if (isset($ar['gateway'])) {
            $this->setGateway($ar['gateway']);
            $this->return_array['gateway'] = $ar['gateway'];
        }
        if (isset($ar['text'])) {
            $this->setText($ar['text']);
            $this->return_array['text'] = $ar['text'];
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
        if (isset($ar['citrix_number'])) {
            $this->return_array['citrix_number'] = $ar['citrix_number'];
        }
        if (isset($ar['password'])) {
            $this->return_array['password'] = $ar['password'];
        }
        if (isset($ar['show_id'])) {
            $this->return_array['show_id'] = $ar['show_id'];
        }

        $citrix_data = [];
        $citrix_sql = " SELECT 
                            ac.id,
                            c.id,
                            c.citrix_number,
                            c.password,
                            c.show_id
                         FROM citrix c
                         JOIN asset_citrix ac ON ac.citrix_id = c.id
                         JOIN asset a ON ac.asset_id = a.id
                         WHERE ac.until IS NULL AND a.id IN ( ";
        $citrix_sql .= " :citrix_id_{$id}, ";
        $citrix_data["citrix_id_{$id}"] = $this->getId();
        $citrix_sql = substr($citrix_sql, 0, -2);
        $citrix_sql .= " ); ";

        $citrixs = $this->getDbHelper()->querySelect($citrix_sql, $citrix_data);

        $citrix = [];
        foreach ($citrixs as $citrix_item) {
            $citrix[] = [
                'id' => $citrix_item['id'],
                'password' => $citrix_item['password'],
                'citrix_number' => $citrix_item['citrix_number'],
                'show_id' => $citrix_item['show_id'],
            ];
        }
        $this->setCitrix($citrix);
        $this->return_array['citrix'] = $citrix;

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
    public function listAssets(
        int $offset,
        int $per_page,
        ?string $search_term = null,
        ?string $order_by = null,
        ?string $sort = null,
        bool $show_inactive = false
    ) {
        $sql = "    SELECT
                        a.id,
                        a.id,
                        a.serial,
                        a.active,
                        a.name,
                        a.type,
                        a.out_of_order,
                        a.is_loan,
                        a.text,
                        a.teamviewer_string,
                        a.dhcp,
                        a.ip,
                        a.subnet,
                        a.dns1,
                        a.dns2,
                        a.gateway,
                        a.place_name,
                        a.from_datetimez,
                        a.city,
                        a.street,
                        a.number,
                        a.citrix ";
        if ($search_term === null) {
            $sql .= "   FROM asset_list_table a ";
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
            if (!$show_inactive) {
                $sql .= " WHERE a.active = true ";
            }
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
        } else {
            $sql .= ",
                CASE
                    WHEN (a.name ILIKE :search_term_1) THEN 1000
                    WHEN (a.name ILIKE :search_term_suffix_1) THEN 100 
                    WHEN (a.name ILIKE :search_term_prefix_1) THEN 100
                    WHEN (a.name ILIKE :search_term_both_1) THEN 80
                    ELSE 0
                END 
                + CASE
                    WHEN (a.serial ILIKE :search_term_2) THEN 800
                    WHEN (a.serial ILIKE :search_term_suffix_2) THEN 60
                    WHEN (a.serial ILIKE :search_term_prefix_2) THEN 60
                    WHEN (a.serial ILIKE :search_term_both_2) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (a.type ILIKE :search_term_3) THEN 800
                    WHEN (a.type ILIKE :search_term_suffix_3) THEN 60
                    WHEN (a.type ILIKE :search_term_prefix_3) THEN 60
                    WHEN (a.type ILIKE :search_term_both_3) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (a.text ILIKE :search_term_4) THEN 500
                    WHEN (a.text ILIKE :search_term_suffix_4) THEN 60
                    WHEN (a.text ILIKE :search_term_prefix_4) THEN 60
                    WHEN (a.text ILIKE :search_term_both_4) THEN 40
                    ELSE 0
                END 
                 + CASE
                    WHEN (a.teamviewer_string ILIKE :search_term_5) THEN 500
                    WHEN (a.teamviewer_string ILIKE :search_term_suffix_5) THEN 60
                    WHEN (a.teamviewer_string ILIKE :search_term_prefix_5) THEN 60
                    WHEN (a.teamviewer_string ILIKE :search_term_both_5) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (a.citrix @> :search_term_json_1) THEN 500
                    ELSE 0
                END
                + CASE
                    WHEN (a.citrix @> :search_term_json_2) THEN 500
                    ELSE 0
                END 
                + CASE
                    WHEN (a.citrix @> :search_term_json_3) THEN 500
                    ELSE 0
                END  
                + CASE
                    WHEN (a.place_name ILIKE :search_term_6) THEN 500
                    WHEN (a.place_name ILIKE :search_term_suffix_6) THEN 60
                    WHEN (a.place_name ILIKE :search_term_prefix_6) THEN 60
                    WHEN (a.place_name ILIKE :search_term_both_6) THEN 40
                    ELSE 0
                END  
                + CASE
                    WHEN (a.city ILIKE :search_term_7) THEN 500
                    WHEN (a.city ILIKE :search_term_suffix_7) THEN 60
                    WHEN (a.city ILIKE :search_term_prefix_7) THEN 60
                    WHEN (a.city ILIKE :search_term_both_7) THEN 40
                    ELSE 0
                END  
                + CASE
                    WHEN (a.street ILIKE :search_term_8) THEN 500
                    WHEN (a.street ILIKE :search_term_suffix_8) THEN 60
                    WHEN (a.street ILIKE :search_term_prefix_8) THEN 60
                    WHEN (a.street ILIKE :search_term_both_8) THEN 40
                    ELSE 0
                END
                AS weight ";
            $sql .= "   FROM asset_list_table a ";
            $sql .= " WHERE ((a.name ILIKE :search_term_w_1)
                        OR (a.serial ILIKE :search_term_w_2)
                        OR (a.type ILIKE :search_term_w_3)
                        OR (a.text ILIKE :search_term_w_4)
                        OR (a.teamviewer_string ILIKE :search_term_w_5)
                        OR (a.place_name ILIKE :search_term_w_6)
                        OR (a.city ILIKE :search_term_w_7)
                        OR (a.street ILIKE :search_term_w_8)
                        OR (a.citrix @> :search_term_json_w_1)
                        OR (a.citrix @> :search_term_json_w_2)
                        OR (a.citrix @> :search_term_json_w_3)
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
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
            for ($i = 1; $i <= 8; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
            $data['search_term_json_1'] = '[{"citrix_number": "'. $search_term . '"}]';
            $data['search_term_json_w_1'] = '[{"citrix_number": "'. $search_term . '"}]';
            $data['search_term_json_2'] = '[{"password": "'. $search_term . '"}]';
            $data['search_term_json_w_2'] = '[{"password": "'. $search_term . '"}]';
            $data['search_term_json_3'] = '[{"show_id": "'. $search_term . '"}]';
            $data['search_term_json_w_3'] = '[{"show_id": "'. $search_term . '"}]';
        }

        $ar = $this->getDbHelper()->querySelect($sql, $data);

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
        $data = [];
        $sql = "SELECT COUNT(a.id), COUNT(a.id) as total FROM asset_list_table a  ";
        if ($search_term === null) {
            if (!$show_inactive) {
                $sql .= " WHERE a.active = true ";
            }
            $sql .= ";";
        } else {
            $sql .= " WHERE ((a.name ILIKE :search_term_w_1)
                        OR (a.serial ILIKE :search_term_w_2)
                        OR (a.type ILIKE :search_term_w_3)
                        OR (a.text ILIKE :search_term_w_4)
                        OR (a.teamviewer_string ILIKE :search_term_w_5)
                        OR (a.name ILIKE :search_term_w_6)
                        OR (a.city ILIKE :search_term_w_7)
                        OR (a.street ILIKE :search_term_w_8)
                        OR (a.citrix @> :search_term_json_1)
                        OR (a.citrix @> :search_term_json_2)
                        OR (a.citrix @> :search_term_json_3)
                        ) ";
            if (!$show_inactive) {
                $sql .= " AND a.active = true ";
            }
            for ($i = 1; $i <= 8; $i++) {
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
            $data['search_term_json_1'] = '[{"citrix_number": "'. $search_term . '"}]';
            $data['search_term_json_2'] = '[{"password": "'. $search_term . '"}]';
            $data['search_term_json_3'] = '[{"show_id": "'. $search_term . '"}]';
        }
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        $ar = array_pop($ar);
        if (isset($ar) && isset($ar['total'])) {
            return (int)$ar['total'];
        } else {
            return 0;
        }
    }

    public function countTypes(?string $search_term = null) : int
    {
        $data = [];
        $sql = "SELECT COUNT(a.id), COUNT(a.id) as total FROM asset a ";
        if ($search_term === null) {
            $sql .= ";";
        } else {
            $sql .= " WHERE (a.type ILIKE :search_term_w_1) ";
            for ($i = 1; $i <= 1; $i++) {
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

    public function listAssetTypes(int $offset, int $per_page, ?string $search_term = null)
    {
        $sql = "SELECT a.type, a.type ";
        if ($search_term === null) {
            $sql .= " FROM asset a
                      ORDER BY a.type LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
        } else {
            $sql .= ",
                CASE
                    WHEN (a.type ILIKE :search_term_1) THEN 800
                    WHEN (a.type ILIKE :search_term_suffix_1) THEN 60
                    WHEN (a.type ILIKE :search_term_prefix_1) THEN 60
                    WHEN (a.type ILIKE :search_term_both_1) THEN 40
                    ELSE 0
                END 
                AS weight ";
            $sql .= " FROM asset a ";
            $sql .= " WHERE (a.type ILIKE :search_term_w_1) ";
            $sql .= " ORDER BY type LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
            for ($i = 1; $i <= 1; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
        }
        return $this->getDbHelper()->querySelect($sql, $data);
    }

    /**
     * @param int $offset
     * @param int $per_page
     * @param string|null $search_term
     * @param string|null $order_by
     * @param string|null $sort
     * @param int|null $asset
     * @param int|null $citrix
     * @param bool $show_inactive
     * @return array
     * @throws DatabaseError
     */
    public function listAssetsCitrix(
        int $offset,
        int $per_page,
        ?string $search_term = null,
        ?string $order_by = null,
        ?string $sort = null,
        ?int $asset,
        ?int $citrix,
        bool $show_inactive = false
    ) {
        $sql = "SELECT
                    ac.id,
                    ac.id,
                    ac.asset_id,
                    ac.citrix_id,
                    ac.from_date,
                    ac.until,
                    a.id as asset_id,
                    a.serial,
                    a.active,
                    a.name,
                    a.type,
                    c.citrix_number,
                    c.id as citrix_id,
                    c.password,
                    c.show_id ";
        if ($search_term === null) {
            $sql .= " FROM asset_citrix ac
                      JOIN asset a ON ac.asset_id = a.id
                      JOIN citrix c ON ac.citrix_id = c.id
                       ";
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
            if (!$show_inactive || $asset !== null || $citrix !== null) {
                $sql .= " WHERE ";
                if (!$show_inactive) {
                    $sql .= " ac.until IS NULL AND ";
                }
                if ($asset !== null) {
                    $sql .= " ac.asset_id = :asset AND ";
                    $data['asset'] = $asset;
                }
                if ($citrix !== null) {
                    $sql .= " ac.citrix_id = :citrix AND ";
                    $data['citrix'] = $citrix;
                }

                $sql = substr($sql, 0, -4);
            }
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data['per_page'] = $per_page;
            $data['offset'] = $offset;
        } else {
            $sql .= ",
                CASE
                    WHEN (a.name ILIKE :search_term_1) THEN 1000
                    WHEN (a.name ILIKE :search_term_suffix_1) THEN 100 
                    WHEN (a.name ILIKE :search_term_prefix_1) THEN 100
                    WHEN (a.name ILIKE :search_term_both_1) THEN 80
                    ELSE 0
                END 
                + CASE
                    WHEN (a.serial ILIKE :search_term_2) THEN 800
                    WHEN (a.serial ILIKE :search_term_suffix_2) THEN 60
                    WHEN (a.serial ILIKE :search_term_prefix_2) THEN 60
                    WHEN (a.serial ILIKE :search_term_both_2) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (a.type ILIKE :search_term_3) THEN 800
                    WHEN (a.type ILIKE :search_term_suffix_3) THEN 60
                    WHEN (a.type ILIKE :search_term_prefix_3) THEN 60
                    WHEN (a.type ILIKE :search_term_both_3) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (a.text ILIKE :search_term_4) THEN 500
                    WHEN (a.text ILIKE :search_term_suffix_4) THEN 60
                    WHEN (a.text ILIKE :search_term_prefix_4) THEN 60
                    WHEN (a.text ILIKE :search_term_both_4) THEN 40
                    ELSE 0
                END 
                 + CASE
                    WHEN (a.teamviewer_string ILIKE :search_term_5) THEN 500
                    WHEN (a.teamviewer_string ILIKE :search_term_suffix_5) THEN 60
                    WHEN (a.teamviewer_string ILIKE :search_term_prefix_5) THEN 60
                    WHEN (a.teamviewer_string ILIKE :search_term_both_5) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (c.citrix_number ILIKE :search_term_6) THEN 500
                    WHEN (c.citrix_number ILIKE :search_term_suffix_6) THEN 60
                    WHEN (c.citrix_number ILIKE :search_term_prefix_6) THEN 60
                    WHEN (c.citrix_number ILIKE :search_term_both_6) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (c.password ILIKE :search_term_7) THEN 500
                    WHEN (c.password ILIKE :search_term_suffix_7) THEN 60
                    WHEN (c.password ILIKE :search_term_prefix_7) THEN 60
                    WHEN (c.password ILIKE :search_term_both_7) THEN 40
                    ELSE 0
                END 
                + CASE
                    WHEN (c.show_id ILIKE :search_term_8) THEN 500
                    WHEN (c.show_id ILIKE :search_term_suffix_8) THEN 60
                    WHEN (c.show_id ILIKE :search_term_prefix_8) THEN 60
                    WHEN (c.show_id ILIKE :search_term_both_8) THEN 40
                    ELSE 0
                END  
                AS weight ";
            $sql .= "   FROM asset_citrix ac 
                        JOIN asset a ON ac.asset_id = a.id
                        JOIN citrix c ON ac.citrix_id = c.id 
                      ";
            $sql .= " WHERE ((a.name ILIKE :search_term_w_1)
                        OR (a.serial ILIKE :search_term_w_2)
                        OR (a.type ILIKE :search_term_w_3)
                        OR (a.text ILIKE :search_term_w_4)
                        OR (a.teamviewer_string ILIKE :search_term_w_5)
                        OR (c.citrix_number ILIKE :search_term_w_6)
                        OR (c.password ILIKE :search_term_w_7)
                        OR (c.show_id ILIKE :search_term_w_8)) ";
            if (!$show_inactive) {
                $sql .= " AND ac.until IS NULL ";
            }
            if ($asset !== null) {
                $sql .= " AND ac.asset_id = :asset ";
                $data['asset'] = $asset;
            }
            if ($citrix !== null) {
                $sql .= " AND ac.citrix_id = :citrix ";
                $data['citrix'] = $citrix;
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
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data['per_page'] = $per_page;
            $data['offset'] = $offset;
            for ($i = 1; $i <= 8; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
        }
        $ar = $this->getDbHelper()->querySelect($sql, $data);

        return $ar;
    }

    public function countAssetCitrix(?string $search_term = null, ?int $asset, ?int $citrix, bool $show_inactive = false): int {
        $data = [];
        $sql = "SELECT COUNT(ac.id), COUNT(ac.id) as total FROM asset_citrix ac JOIN citrix c ON ac.citrix_id = c.id JOIN asset a ON ac.asset_id = a.id ";
        if ($search_term === null) {
            if (!$show_inactive) {
                $sql .= " WHERE ac.until IS NULL ";
            }
            $sql .= ";";
        } else {
            $sql .= " WHERE ((a.name ILIKE :search_term_w_1)
                        OR (a.serial ILIKE :search_term_w_2)
                        OR (a.type ILIKE :search_term_w_3)
                        OR (a.text ILIKE :search_term_w_4)
                        OR (a.teamviewer_string ILIKE :search_term_w_5)
                        OR (c.citrix_number ILIKE :search_term_w_6)
                        OR (c.password ILIKE :search_term_w_7)
                        OR (c.show_id ILIKE :search_term_w_8)) ";
            if (!$show_inactive) {
                $sql .= " AND ac.until IS NULL ";
            }
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

    public function countNames(?string $search_term = null) : int
    {
        $data = [];
        $sql = "SELECT COUNT(a.id), COUNT(a.id) as total FROM asset a ";
        if ($search_term === null) {
            $sql .= ";";
        } else {
            $sql .= " WHERE (a.name ILIKE :search_term_w_1) ";
            for ($i = 1; $i <= 1; $i++) {
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

    public function listAssetNames(int $offset, int $per_page, ?string $search_term = null)
    {
        $sql = "SELECT a.name, a.name ";
        if ($search_term === null) {
            $sql .= " FROM asset a
                      GROUP BY a.name
                      ORDER BY a.name LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
        } else {
            $sql .= ",
                CASE
                    WHEN (a.name ILIKE :search_term_1) THEN 800
                    WHEN (a.name ILIKE :search_term_suffix_1) THEN 60
                    WHEN (a.name ILIKE :search_term_prefix_1) THEN 60
                    WHEN (a.name ILIKE :search_term_both_1) THEN 40
                    ELSE 0
                END 
                AS weight ";
            $sql .= " FROM asset a ";
            $sql .= " WHERE (a.name ILIKE :search_term_w_1) ";
            $sql .= " ORDER BY name LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
            for ($i = 1; $i <= 1; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
        }
        return $this->getDbHelper()->querySelect($sql, $data);
    }

    public function toArray()
    {
        return $this->return_array;
    }
}
