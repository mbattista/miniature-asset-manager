<?php
declare(strict_types=1);

namespace AssetManager\Models;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\PlacesAssetsNotFoundException;
use AssetManager\Traits\DbHelperTrait;
use AssetManager\Traits\TimestampTrait;
use DateTime;

class PlacesAssets
{
    use DbHelperTrait;
    use TimestampTrait;

    protected array $order_items = [
        'id' => 'pa.id',
        'from_datetimez' => 'pa.from_datetimez',
        'weight' => 'weight',
    ];
    protected array $sort_items = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    protected int $id;
    protected int $place;
    protected int $asset;
    protected ?int $deliverer_person;
    protected ?int $receiver_person;
    protected ?DateTime $delivery_datetimez;
    protected ?DateTime $from_datetimez;
    protected ?DateTime $until_datetimez;
    protected ?DateTime $pickup_datetimez;
    protected ?int $pickup_person_id;
    protected ?int $pickup_responsible_person_id;
    protected ?bool $automatic_callback;
    protected ?string $text;
    protected bool $delivered;
    protected ?string $external_person;

    protected array $return_array = [];

    public function __construct()
    {
        $this->id = 0;
        $this->place = 0;
        $this->asset = 0;
        $this->deliverer_person = null;
        $this->receiver_person = null;
        $this->delivery_datetimez = null;
        $this->from_datetimez = null;
        $this->until_datetimez = null;
        $this->pickup_datetimez = null;
        $this->pickup_person_id = null;
        $this->delivered = false;
        $this->pickup_responsible_person_id = null;
        $this->automatic_callback = false;
        $this->text = null;
        $this->external_person = null;
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
     * @return PlacesAssets
     */
    public function setId(int $id): PlacesAssets
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlace(): int
    {
        return $this->place;
    }

    /**
     * @param int $place
     * @return PlacesAssets
     */
    public function setPlace(int $place): PlacesAssets
    {
        $this->place = $place;
        return $this;
    }

    /**
     * @return int
     */
    public function getAsset(): int
    {
        return $this->asset;
    }

    /**
     * @param int $asset
     * @return PlacesAssets
     */
    public function setAsset(int $asset): PlacesAssets
    {
        $this->asset = $asset;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDelivererPerson(): ?int
    {
        return $this->deliverer_person;
    }

    /**
     * @param int|null $deliverer_person
     * @return PlacesAssets
     */
    public function setDelivererPerson(?int $deliverer_person): PlacesAssets
    {
        $this->deliverer_person = $deliverer_person;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReceiverPerson(): ?int
    {
        return $this->receiver_person;
    }

    /**
     * @param int|null $receiver_person
     * @return PlacesAssets
     */
    public function setReceiverPerson(?int $receiver_person): PlacesAssets
    {
        $this->receiver_person = $receiver_person;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDeliveryDatetimez(): ?DateTime
    {
        return $this->delivery_datetimez;
    }

    /**
     * @param DateTime|null $delivery_datetimez
     * @return PlacesAssets
     */
    public function setDeliveryDatetimez(?DateTime $delivery_datetimez): PlacesAssets
    {
        $this->delivery_datetimez = $delivery_datetimez;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getFromDatetimez(): ?DateTime
    {
        return $this->from_datetimez;
    }

    /**
     * @param DateTime|null $from_datetimez
     * @return PlacesAssets
     */
    public function setFromDatetimez(?DateTime $from_datetimez): PlacesAssets
    {
        $this->from_datetimez = $from_datetimez;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUntilDatetimez(): ?DateTime
    {
        return $this->until_datetimez;
    }

    /**
     * @param DateTime|null $until_datetimez
     * @return PlacesAssets
     */
    public function setUntilDatetimez(?DateTime $until_datetimez): PlacesAssets
    {
        $this->until_datetimez = $until_datetimez;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getPickupDatetimez(): ?DateTime
    {
        return $this->pickup_datetimez;
    }

    /**
     * @param DateTime|null $pickup_datetimez
     * @return PlacesAssets
     */
    public function setPickupDatetimez(?DateTime $pickup_datetimez): PlacesAssets
    {
        $this->pickup_datetimez = $pickup_datetimez;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPickupPersonId(): ?int
    {
        return $this->pickup_person_id;
    }

    /**
     * @param int|null $pickup_person_id
     * @return PlacesAssets
     */
    public function setPickupPersonId(?int $pickup_person_id): PlacesAssets
    {
        $this->pickup_person_id = $pickup_person_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPickupResponsiblePersonId(): ?int
    {
        return $this->pickup_responsible_person_id;
    }

    /**
     * @param int|null $pickup_responsible_person_id
     * @return PlacesAssets
     */
    public function setPickupResponsiblePersonId(?int $pickup_responsible_person_id): PlacesAssets
    {
        $this->pickup_responsible_person_id = $pickup_responsible_person_id;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAutomaticCallback(): ?bool
    {
        return $this->automatic_callback;
    }

    /**
     * @param bool|null $automatic_callback
     * @return PlacesAssets
     */
    public function setAutomaticCallback(?bool $automatic_callback): PlacesAssets
    {
        $this->automatic_callback = $automatic_callback;
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
     * @return PlacesAssets
     */
    public function setText(?string $text): PlacesAssets
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return bool|false
     */
    public function getDelivered()
    {
        return $this->delivered ? 'true' : 'false';
    }

    /**
     * @return bool|false
     */
    public function isDelivered()
    {
        return $this->delivered;
    }

    /**
     * @param bool|false $delivered
     * @return PlacesAssets
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalPerson(): ?string
    {
        return $this->external_person;
    }

    /**
     * @param string|null $external_person
     * @return PlacesAssets
     */
    public function setExternalPerson(?string $external_person): PlacesAssets
    {
        $this->external_person = $external_person;
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
        $sql = "UPDATE places_assets SET 
                    asset_id = :asset, 
                    place_id = :place,
                    deliverer_person_id = :deliverer_person,
                    receiver_person_id =  :receiver_person,
                    pickup_person_id = :pickup_person_id,
                    pickup_responsible_person_id = :pickup_responsible_person_id,
                    automatic_callback = :automatic_callback,
                    text = :text, 
                    delivery_datetimez = :delivery_datetimez,
                    from_datetimez = :from_datetimez,
                    until_datetimez = :until_datetimez,
                    pickup_datetimez = :pickup_datetimez,
                    external_person = :external_person,
                    delivered = :delivered,
                    updated = NOW()
                WHERE id = :id;";
        $data = [
            'id' => $this->getId(),
            'asset' => $this->getAsset(),
            'place' => $this->getPlace(),
            'deliverer_person' => $this->getDelivererPerson(),
            'receiver_person' => $this->getReceiverPerson(),
            'pickup_person_id' => $this->getPickupPersonId(),
            'pickup_responsible_person_id' => $this->getPickupResponsiblePersonId(),
            'automatic_callback' => ($this->getAutomaticCallback() ? 'true' : 'false'),
            'text' => $this->getText(),
            'delivered' => (string)$this->getDelivered(),
            'delivery_datetimez' => ($this->getDeliveryDatetimez() !== null ? $this->getDeliveryDatetimez()->format('Y-m-d H:i:s') : null),
            'until_datetimez' => ($this->getUntilDatetimez() !== null ? $this->getUntilDatetimez()->format('Y-m-d H:i:s') : null),
            'from_datetimez' => ($this->getFromDatetimez() !== null ? $this->getFromDatetimez()->format('Y-m-d H:i:s') : null),
            'pickup_datetimez' => ($this->getPickupDatetimez() !== null ? $this->getPickupDatetimez()->format('Y-m-d H:i:s') : null),
            'external_person' => $this->getExternalPerson(),
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
        $sql = "UPDATE places_assets
                SET until_datetimez = :until_datetimez 
                WHERE asset_id = :asset AND id = (SELECT MAX(id) FROM places_assets WHERE asset_id = :asset_sub) ; ";
        $now = new DateTime();
        $data = [
            'until_datetimez' => ($this->getFromDatetimez() !== null ? $this->getFromDatetimez()->format('Y-m-d H:i:s') : $now->format('Y-m-d H:i:s')),
            'asset' => $this->getAsset(),
            'asset_sub' => $this->getAsset(),
        ];
        $this->getDbHelper()->queryUpdate($sql, $data);

        $sql = "INSERT INTO places_assets (
                    asset_id,
                    place_id,
                    deliverer_person_id,
                    receiver_person_id,
                    pickup_person_id,
                    pickup_responsible_person_id,
                    automatic_callback,
                    text,
                    delivered,
                    delivery_datetimez,
                    from_datetimez,
                    until_datetimez,
                    pickup_datetimez,
                    external_person
                ) VALUES (
                    :asset,
                    :place,
                    :deliverer_person,
                    :receiver_person,
                    :pickup_person_id,
                    :pickup_responsible_person_id,
                    :automatic_callback,
                    :text,
                    :delivered,
                    :delivery_datetimez,
                    :from_datetimez,
                    :until_datetimez,
                    :pickup_datetimez,
                    :external_person
                )";

        $data = [
            'asset' => $this->getAsset(),
            'place' => $this->getPlace(),
            'deliverer_person' => $this->getDelivererPerson(),
            'receiver_person' => $this->getReceiverPerson(),
            'pickup_person_id' => $this->getPickupPersonId(),
            'pickup_responsible_person_id' => $this->getPickupResponsiblePersonId(),
            'automatic_callback' => ($this->getAutomaticCallback() ? 'true' : 'false'),
            'text' => $this->getText(),
            'delivered' => (string)$this->getDelivered(),
            'delivery_datetimez' => ($this->getDeliveryDatetimez() !== null ? $this->getDeliveryDatetimez()->format('Y-m-d H:i:s') : null),
            'until_datetimez' => ($this->getUntilDatetimez() !== null ? $this->getUntilDatetimez()->format('Y-m-d H:i:s') : null),
            'from_datetimez' => ($this->getFromDatetimez() !== null ? $this->getFromDatetimez()->format('Y-m-d H:i:s') : null),
            'pickup_datetimez' => ($this->getPickupDatetimez() !== null ? $this->getPickupDatetimez()->format('Y-m-d H:i:s') : null),
            'external_person' => $this->getExternalPerson(),
        ];

        $return = $this->getDbHelper()->queryInsert($sql, $data);
        return $return;
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM places_assets WHERE id = :id;";
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
     * @throws PlacesAssetsNotFoundException
     * @throws DatabaseError
     */
    public function get(int $id): PlacesAssets
    {
        $sql = "
            SELECT 
                pa.id,
                pa.id,
                pa.asset_id,
                pa.place_id,
                pa.deliverer_person_id,
                pa.receiver_person_id,
                pa.pickup_person_id,
                pa.pickup_responsible_person_id,
                pa.automatic_callback,
                pa.text,
                pa.delivered,
                pa.delivery_datetimez,
                pa.from_datetimez,
                pa.until_datetimez,
                pa.pickup_datetimez,
                pa.external_person,
                a.name,
                a.type,
                a.serial,
                a.out_of_order,
                a.active,
                c.citrix_number,
                p.name as place_name,
                p.city,
                rp.last_name as rp_last_name,
                rp.first_name as rp_first_name,
                dp.last_name as dp_last_name,
                dp.first_name as dp_first_name,
                pp.last_name as pp_last_name,
                pp.first_name as pp_first_name,
                pr.last_name as pr_last_name,
                pr.first_name as pr_first_name,
                pa.created,
                pa.updated
            FROM places_assets pa
            LEFT OUTER JOIN asset a ON pa.asset_id = a.id
            LEFT OUTER JOIN citrix c ON a.citrix_id = c.id
            LEFT OUTER JOIN place p on pa.place_id = p.id
            LEFT OUTER JOIN asset_user rpau on pa.receiver_person_id = rpau.id
            LEFT OUTER JOIN person rp on rpau.person_id = rp.id
            LEFT OUTER JOIN asset_user dpau on pa.deliverer_person_id = dpau.id
            LEFT OUTER JOIN person dp on dpau.person_id = dp.id
            LEFT OUTER JOIN asset_user ppau on pa.pickup_person_id = ppau.id
            LEFT OUTER JOIN person pp on ppau.person_id = pp.id
            LEFT OUTER JOIN asset_user prau on pa.pickup_responsible_person_id = prau.id
            LEFT OUTER JOIN person pr on prau.person_id = pr.id
            WHERE pa.id = :id;
        ";
        $data = [
            'id' => $id,
        ];
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        if (count($ar) === 0) {
            throw new PlacesAssetsNotFoundException();
        }
        $ar = array_pop($ar);

        $this->setId((int)$ar['id']);
        $this->return_array['id'] = (int)$ar['id'];
        if (isset($ar['asset'])) {
            $this->setAsset($ar['asset']);
            $this->return_array['asset'] = $ar['asset'];
        }
        if (isset($ar['place'])) {
            $this->setPlace($ar['place']);
            $this->return_array['place'] = $ar['place'];
        }
        if (isset($ar['deliverer_person'])) {
            $this->setDelivererPerson($ar['deliverer_person']);
            $this->return_array['deliverer_person'] = $ar['deliverer_person'];
        }
        if (isset($ar['receiver_person'])) {
            $this->setReceiverPerson($ar['receiver_person']);
            $this->return_array['receiver_person'] = $ar['receiver_person'];
        }
        if (isset($ar['pickup_person_id'])) {
            $this->setPickupPersonId($ar['pickup_person_id']);
            $this->return_array['pickup_person_id'] = $ar['pickup_person_id'];
        }
        if (isset($ar['pickup_responsible_person_id'])) {
            $this->setPickupResponsiblePersonId($ar['pickup_responsible_person_id']);
            $this->return_array['pickup_responsible_person_id'] = $ar['pickup_responsible_person_id'];
        }
        if (isset($ar['automatic_callback'])) {
            $this->setAutomaticCallback($ar['automatic_callback']);
            $this->return_array['automatic_callback'] = $ar['automatic_callback'];
        }
        if (isset($ar['text'])) {
            $this->setText($ar['text']);
            $this->return_array['text'] = $ar['text'];
        }
        if (isset($ar['external_person'])) {
            $this->setExternalPerson($ar['external_person']);
            $this->return_array['external_person'] = $ar['external_person'];
        }
        if (isset($ar['delivered'])) {
            $this->setDelivered($ar['delivered']);
            $this->return_array['delivered'] = $ar['delivered'];
        }
        if (isset($ar['delivery_datetimez'])) {
            if ($ar['delivery_datetimez'] !== null) {
                $tmp = new DateTime($ar['delivery_datetimez']);
            } else {
                $tmp = null;
            }
            $this->setDeliveryDatetimez($tmp);
            $this->return_array['delivery_datetimez'] = $tmp;
        }
        if (isset($ar['from_datetimez'])) {
            if ($ar['from_datetimez'] !== null) {
                $tmp = new DateTime($ar['from_datetimez']);
            } else {
                $tmp = null;
            }
            $this->setFromDatetimez($tmp);
            $this->return_array['from_datetimez'] = $tmp;
        }
        if (isset($ar['until_datetimez'])) {
            if ($ar['until_datetimez'] !== null) {
                $tmp = new DateTime($ar['until_datetimez']);
            } else {
                $tmp = null;
            }
            $this->setUntilDatetimez($tmp);
            $this->return_array['until_datetimez'] = $tmp;
        }
        if (isset($ar['pickup_datetimez'])) {
            if ($ar['pickup_datetimez'] !== null) {
                $tmp = new DateTime($ar['pickup_datetimez']);
            } else {
                $tmp = null;
            }
            $this->setPickupDatetimez($tmp);
            $this->return_array['pickup_datetimez'] = $tmp;
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

        if (isset($ar['name'])) {
            $this->return_array['name'] = $ar['name'];
        }
        if (isset($ar['type'])) {
            $this->return_array['type'] = $ar['type'];
        }
        if (isset($ar['serial'])) {
            $this->return_array['serial'] = $ar['serial'];
        }
        if (isset($ar['out_of_order'])) {
            $this->return_array['out_of_order'] = $ar['out_of_order'];
        }
        if (isset($ar['active'])) {
            $this->return_array['active'] = $ar['active'];
        }
        if (isset($ar['citrix_number'])) {
            $this->return_array['citrix_number'] = $ar['citrix_number'];
        }
        if (isset($ar['place_name'])) {
            $this->return_array['place_name'] = $ar['place_name'];
        }
        if (isset($ar['city'])) {
            $this->return_array['city'] = $ar['city'];
        }

        if (isset($ar['rp_last_name'])) {
            $this->return_array['rp_last_name'] = $ar['rp_last_name'];
        }
        if (isset($ar['rp_first_name'])) {
            $this->return_array['rp_first_name'] = $ar['rp_first_name'];
        }
        if (isset($ar['dp_last_name'])) {
            $this->return_array['dp_last_name'] = $ar['dp_last_name'];
        }
        if (isset($ar['dp_first_name'])) {
            $this->return_array['dp_first_name'] = $ar['dp_first_name'];
        }
        if (isset($ar['pp_last_name'])) {
            $this->return_array['pp_last_name'] = $ar['pp_last_name'];
        }
        if (isset($ar['pp_first_name'])) {
            $this->return_array['pp_first_name'] = $ar['pp_first_name'];
        }
        if (isset($ar['pr_last_name'])) {
            $this->return_array['pr_last_name'] = $ar['pr_last_name'];
        }
        if (isset($ar['pr_first_name'])) {
            $this->return_array['pr_first_name'] = $ar['pr_first_name'];
        }

        return $this;
    }

    /**
     * @param int $offset
     * @param int $per_page
     * @param string|null $search_term
     * @param int|null $asset
     * @param int|null $place
     * @param int|null $deliverer_person
     * @param int|null $receiver_person
     * @param int|null $pickup_person_id
     * @param int|null $pickup_responsible_person_id
     * @param string|null $order_by
     * @param string|null $sort
     * @param bool $show_history
     * @param bool $show_future
     * @param string|null $from_date
     * @param string|null $until_date
     * @param bool $show_only_newest
     * @return array
     * @throws DatabaseError
     */
    public function lists(
        int $offset,
        int $per_page,
        ?string $search_term = null,
        ?int $asset = null,
        ?int $place = null,
        ?int $deliverer_person = null,
        ?int $receiver_person = null,
        ?int $pickup_person_id = null,
        ?int $pickup_responsible_person_id = null,
        ?string $order_by = null,
        ?string $sort = null,
        bool $show_history = false,
        bool $show_future = false,
        ?string $from_date = null,
        ?string $until_date = null,
        bool $show_only_newest = false,
        ?string $lookup_date = null
    ): array {
        $data = [];
        $sql = "SELECT 
                pa.id,
                pa.id,
                pa.asset_id,
                pa.place_id,
                pa.deliverer_person_id,
                pa.receiver_person_id,
                pa.pickup_person_id,
                pa.pickup_responsible_person_id,
                pa.automatic_callback,
                pa.text,
                pa.delivered,
                pa.delivery_datetimez,
                pa.from_datetimez,
                pa.until_datetimez,
                pa.pickup_datetimez,
                pa.external_person,
                a.name,
                a.type,
                a.serial,
                a.out_of_order,
                a.active,
                c.citrix_number,
                p.name as place_name,
                p.city,
                p.postcode,
                p.number,
                p.street,
                rp.last_name as rp_last_name,
                rp.first_name as rp_first_name,
                dp.last_name as dp_last_name,
                dp.first_name as dp_first_name,
                pp.last_name as pp_last_name,
                pp.first_name as pp_first_name,
                pr.last_name as pr_last_name,
                pr.first_name as pr_first_name
        ";
        if ($search_term === null) {
            $sql .= "FROM places_assets pa
            LEFT OUTER JOIN asset a ON pa.asset_id = a.id
            LEFT OUTER JOIN asset_citrix ac ON ac.asset_id = a.id 
            LEFT OUTER JOIN citrix c on ac.citrix_id = c.id
            LEFT OUTER JOIN place p on pa.place_id = p.id
            LEFT OUTER JOIN asset_user rpau on pa.receiver_person_id = rpau.id
            LEFT OUTER JOIN person rp on rpau.person_id = rp.id
            LEFT OUTER JOIN asset_user dpau on pa.deliverer_person_id = dpau.id
            LEFT OUTER JOIN person dp on dpau.person_id = dp.id
            LEFT OUTER JOIN asset_user ppau on pa.pickup_person_id = ppau.id
            LEFT OUTER JOIN person pp on ppau.person_id = pp.id
            LEFT OUTER JOIN asset_user prau on pa.pickup_responsible_person_id = prau.id
            LEFT OUTER JOIN person pr on prau.person_id = pr.id ";

            if ($asset !== null ||
                $place !== null ||
                $deliverer_person !== null ||
                $receiver_person !== null ||
                $pickup_person_id !== null ||
                $pickup_responsible_person_id !== null ||
                !$show_history ||
                !$show_future ||
                $until_date !== null ||
                $from_date !== null ||
                $show_only_newest ||
                $lookup_date !== null
            ) {
                $sql .= " WHERE ";
                if ($asset !== null) {
                    $sql .= "pa.asset_id = :asset AND ";
                    $data['asset'] = $asset;
                }
                if ($place !== null) {
                    $sql .= "pa.place_id = :place AND ";
                    $data['place'] = $place;
                }
                if ($deliverer_person !== null) {
                    $sql .= "pa.deliverer_person_id = :deliverer_person AND ";
                    $data['deliverer_person'] = $deliverer_person;
                }
                if ($receiver_person !== null) {
                    $sql .= "pa.receiver_person_id = :receiver_person AND ";
                    $data['receiver_person'] = $receiver_person;
                }
                if ($pickup_person_id !== null) {
                    $sql .= "pa.pickup_person_id = :pickup_person_id AND ";
                    $data['pickup_person_id'] = $pickup_person_id;
                }
                if ($pickup_responsible_person_id !== null) {
                    $sql .= "pa.pickup_responsible_person_id = :pickup_responsible_person_id AND ";
                    $data['pickup_responsible_person_id'] = $pickup_responsible_person_id;
                }
                if ($lookup_date === null) {
                    if (!$show_history && !$show_future) {
                        $sql .= " ( pa.until_datetimez IS NULL ) AND ";
                    } elseif (!$show_future) {
                        $sql .= " (pa.from_datetimez < NOW() AND pa.until_datetimez IS NULL) AND ";
                    } else {
                        if (!$show_history) {
                            $sql .= " (pa.from_datetimez > NOW() AND pa.until_datetimez IS NULL) AND ";
                        }
                    }
                    if ($show_only_newest) {
                        $sql .= " (pa.until_datetimez IS NULL) AND ";
                    }
                    if ($from_date !== null) {
                        $sql .= " (pa.from_datetimez > :from_date) AND ";
                        $data['from_date'] = $from_date;
                    }
                    if ($until_date !== null) {
                        $sql .= " (pa.from_datetimez < :until_date) AND ";
                        $data['until_date'] = $until_date;
                    }
                } elseif ($lookup_date !== null) {
                    $sql .= " ((pa.from_datetimez::date = :lookup_date_from) OR (pa.until_datetimez::date = :lookup_date_until)) AND ";
                    $data['lookup_date_from'] = $lookup_date;
                    $data['lookup_date_until'] = $lookup_date;
                }
                $sql = substr($sql, 0, -4);
            }
            if (isset($this->order_items[$order_by])) {
                $order_by_sql = $this->order_items[$order_by];
            } else {
                $order_by_sql = $this->order_items['from_datetimez'];
            }
            if (isset($this->sort_items[$sort])) {
                $sort_sql = $this->sort_items[$sort];
            } else {
                $sort_sql = $this->sort_items['desc'];
            }

            $sql .= "ORDER BY {$order_by_sql} {$sort_sql} LIMIT :per_page OFFSET :offset;";
            $data['per_page'] = $per_page;
            $data['offset'] = $offset;
        } else {
            $sql .= ",
                CASE
                    WHEN (pa.text ILIKE :search_term_1) THEN 1000 
                    WHEN (pa.text ILIKE :search_term_suffix_1) THEN 30
                    WHEN (pa.text ILIKE :search_term_prefix_1) THEN 20
                    WHEN (pa.text ILIKE :search_term_both_1) THEN 10
                    ELSE 0
                END
                + CASE
                    WHEN (a.name ILIKE :search_term_2) THEN 1000 
                    WHEN (a.name ILIKE :search_term_suffix_2) THEN 250
                    WHEN (a.name ILIKE :search_term_prefix_2) THEN 200
                    WHEN (a.name ILIKE :search_term_both_2) THEN 100
                    ELSE 0
                END
                + CASE
                    WHEN (a.type ILIKE :search_term_4) THEN 1000 
                    WHEN (a.type ILIKE :search_term_suffix_4) THEN 200
                    WHEN (a.type ILIKE :search_term_prefix_4) THEN 180
                    WHEN (a.type ILIKE :search_term_both_4) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (a.serial ILIKE :search_term_5) THEN 1000 
                    WHEN (a.serial ILIKE :search_term_suffix_5) THEN 200
                    WHEN (a.serial ILIKE :search_term_prefix_5) THEN 180
                    WHEN (a.serial ILIKE :search_term_both_5) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (p.name ILIKE :search_term_6) THEN 1000 
                    WHEN (p.name ILIKE :search_term_suffix_6) THEN 210
                    WHEN (p.name ILIKE :search_term_prefix_6) THEN 190
                    WHEN (p.name ILIKE :search_term_both_6) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (p.city ILIKE :search_term_7) THEN 1000 
                    WHEN (p.city ILIKE :search_term_suffix_7) THEN 90
                    WHEN (p.city ILIKE :search_term_prefix_7) THEN 70
                    WHEN (p.city ILIKE :search_term_both_7) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (rp.last_name ILIKE :search_term_8) THEN 1000 
                    WHEN (rp.last_name ILIKE :search_term_suffix_8) THEN 100
                    WHEN (rp.last_name ILIKE :search_term_prefix_8) THEN 80
                    WHEN (rp.last_name ILIKE :search_term_both_8) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (rp.first_name ILIKE :search_term_9) THEN 1000 
                    WHEN (rp.first_name ILIKE :search_term_suffix_9) THEN 100
                    WHEN (rp.first_name ILIKE :search_term_prefix_9) THEN 80
                    WHEN (rp.first_name ILIKE :search_term_both_9) THEN 40
                    ELSE 0
                END
                + CASE
                    WHEN (dp.last_name ILIKE :search_term_3) THEN 1000 
                    WHEN (dp.last_name ILIKE :search_term_suffix_3) THEN 120
                    WHEN (dp.last_name ILIKE :search_term_prefix_3) THEN 100
                    WHEN (dp.last_name ILIKE :search_term_both_3) THEN 80
                    ELSE 0
                END
                 + CASE
                    WHEN (dp.first_name ILIKE :search_term_10) THEN 1000 
                    WHEN (dp.first_name ILIKE :search_term_suffix_10) THEN 120
                    WHEN (dp.first_name ILIKE :search_term_prefix_10) THEN 100
                    WHEN (dp.first_name ILIKE :search_term_both_10) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (pp.last_name ILIKE :search_term_11) THEN 1000 
                    WHEN (pp.last_name ILIKE :search_term_suffix_11) THEN 120
                    WHEN (pp.last_name ILIKE :search_term_prefix_11) THEN 100
                    WHEN (pp.last_name ILIKE :search_term_both_11) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (pp.first_name ILIKE :search_term_12) THEN 1000 
                    WHEN (pp.first_name ILIKE :search_term_suffix_12) THEN 120
                    WHEN (pp.first_name ILIKE :search_term_prefix_12) THEN 100
                    WHEN (pp.first_name ILIKE :search_term_both_12) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (pr.last_name ILIKE :search_term_13) THEN 1000 
                    WHEN (pr.last_name ILIKE :search_term_suffix_13) THEN 120
                    WHEN (pr.last_name ILIKE :search_term_prefix_13) THEN 100
                    WHEN (pr.last_name ILIKE :search_term_both_13) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (pr.first_name ILIKE :search_term_14) THEN 1000 
                    WHEN (pr.first_name ILIKE :search_term_suffix_14) THEN 120
                    WHEN (pr.first_name ILIKE :search_term_prefix_14) THEN 100
                    WHEN (pr.first_name ILIKE :search_term_both_14) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (c.citrix_number ILIKE :search_term_15) THEN 1000 
                    WHEN (c.citrix_number ILIKE :search_term_suffix_15) THEN 200
                    WHEN (c.citrix_number ILIKE :search_term_prefix_15) THEN 180
                    WHEN (c.citrix_number ILIKE :search_term_both_15) THEN 80
                    ELSE 0
                END
                + CASE
                    WHEN (pa.external_person ILIKE :search_term_16) THEN 1000 
                    WHEN (pa.external_person ILIKE :search_term_suffix_16) THEN 200
                    WHEN (pa.external_person ILIKE :search_term_prefix_16) THEN 180
                    WHEN (pa.external_person ILIKE :search_term_both_16) THEN 80
                    ELSE 0
                END
                - CASE 
                    WHEN (pa.until_datetimez IS NOT NULL) THEN 500
                    ELSE 0 
                END ";
            $sql .= " AS weight ";
            $sql .= " FROM places_assets pa
            LEFT OUTER JOIN asset a ON pa.asset_id = a.id
            LEFT OUTER JOIN asset_citrix ac ON ac.asset_id = a.id
            LEFT OUTER JOIN citrix c on ac.citrix_id = c.id
            LEFT OUTER JOIN place p on pa.place_id = p.id
            LEFT OUTER JOIN asset_user rpau on pa.receiver_person_id = rpau.id
            LEFT OUTER JOIN person rp on rpau.person_id = rp.id
            LEFT OUTER JOIN asset_user dpau on pa.deliverer_person_id = dpau.id
            LEFT OUTER JOIN person dp on dpau.person_id = dp.id
            LEFT OUTER JOIN asset_user ppau on pa.pickup_person_id = ppau.id
            LEFT OUTER JOIN person pp on ppau.person_id = pp.id
            LEFT OUTER JOIN asset_user prau on pa.pickup_responsible_person_id = prau.id
            LEFT OUTER JOIN person pr on prau.person_id = pr.id ";
            $sql .= " WHERE ";

            if ($asset !== null ||
                $place !== null ||
                $deliverer_person !== null ||
                $receiver_person !== null ||
                $pickup_person_id !== null ||
                $pickup_responsible_person_id !== null ||
                !$show_history ||
                !$show_future ||
                $from_date !== null ||
                $until_date !== null ||
                $show_only_newest ||
                $lookup_date !== null
            ) {
                if ($asset !== null) {
                    $sql .= "pa.asset_id = :asset AND ";
                    $data['asset'] = $asset;
                }
                if ($place !== null) {
                    $sql .= "pa.place_id = :place AND ";
                    $data['place'] = $place;
                }
                if ($deliverer_person !== null) {
                    $sql .= "pa.deliverer_person_id = :deliverer_person AND ";
                    $data['deliverer_person'] = $deliverer_person;
                }
                if ($receiver_person !== null) {
                    $sql .= "pa.receiver_person_id = :receiver_person AND ";
                    $data['receiver_person'] = $receiver_person;
                }
                if ($pickup_person_id !== null) {
                    $sql .= "pa.pickup_person_id = :pickup_person_id AND ";
                    $data['pickup_person_id'] = $pickup_person_id;
                }
                if ($pickup_responsible_person_id !== null) {
                    $sql .= "pa.pickup_responsible_person_id = :pickup_responsible_person_id AND ";
                    $data['pickup_responsible_person_id'] = $pickup_responsible_person_id;
                }
                if ($lookup_date === null) {
                    if (!$show_history && !$show_future) {
                        $sql .= " ( pa.until_datetimez IS NULL ) AND ";
                    } elseif (!$show_future) {
                        $sql .= " (pa.from_datetimez < NOW() AND pa.until_datetimez IS NULL) AND ";
                    } else {
                        if (!$show_history) {
                            $sql .= " (pa.from_datetimez > NOW() AND pa.until_datetimez IS NULL) AND ";
                        }
                    }
                    if ($show_only_newest) {
                        $sql .= " (pa.until_datetimez IS NULL) AND ";
                    }
                    if ($from_date !== null) {
                        $sql .= " (pa.from_datetimez > :from_date) AND ";
                        $data['from_date'] = $from_date;
                    }
                    if ($until_date !== null) {
                        $sql .= " (pa.from_datetimez < :until_date) AND ";
                        $data['until_date'] = $until_date;
                    }
                } elseif ($lookup_date !== null) {
                    $sql .= " ((pa.from_datetimez::date = :lookup_date_from) OR (pa.until_datetimez::date = :lookup_date_until)) AND ";
                    $data['lookup_date_from'] = $lookup_date;
                    $data['lookup_date_until'] = $lookup_date;
                }
            }

            $sql .= "
                ((pa.text ILIKE :search_term_w_1) OR
                (a.name ILIKE :search_term_w_2) OR
                (a.type ILIKE :search_term_w_4) OR
                (a.serial ILIKE :search_term_w_5) OR
                (p.name ILIKE :search_term_w_6) OR
                (p.city ILIKE :search_term_w_7) OR
                (rp.last_name ILIKE :search_term_w_8) OR
                (rp.first_name ILIKE :search_term_w_9) OR
                (dp.last_name ILIKE :search_term_w_10) OR
                (dp.first_name ILIKE :search_term_w_11) OR
                (pp.last_name ILIKE :search_term_w_12) OR
                (pp.first_name ILIKE :search_term_w_13) OR
                (pr.last_name ILIKE :search_term_w_14) OR
                (c.citrix_number ILIKE :search_term_w_15) OR
                (pa.external_person ILIKE :search_term_w_16) OR
                (pr.first_name ILIKE :search_term_w_3)) ";
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
            $sql .= " ORDER BY {$order_by_sql} {$sort_sql}, pa.id LIMIT :per_page OFFSET :offset;";
            $data['offset'] = $offset;
            $data['per_page'] = $per_page;

            for ($i = 1; $i <= 16; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
            }
        }

        $ar = $this->getDbHelper()->querySelect($sql, $data);

        if (!empty($ar)) {
            foreach ($ar as $key => $value) {
                $current_place_sql = "
                    SELECT
                        0,
                        pa.asset_id,
                        pa.place_id,
                        paap.name as current_place_name,
                        paap.city as current_city,
                        paap.postcode as current_postcode,
                        paap.number as current_number,
                        paap.street as current_street
                    FROM places_assets pa
                    LEFT OUTER JOIN place paap ON pa.place_id = paap.id
                    WHERE pa.id = (SELECT MAX(id) FROM places_assets WHERE asset_id = :asset);
                ";
                $current_place_data['asset'] = $value['asset_id'];
                $current_place = $this->getDbHelper()->querySelect($current_place_sql, $current_place_data);

                $ar[$key]['current_place'] = $current_place[0]['place_id'];
                $ar[$key]['current_place_name'] = $current_place[0]['current_place_name'];
                $ar[$key]['current_city'] = $current_place[0]['current_city'];
                $ar[$key]['current_postcode'] = $current_place[0]['current_postcode'];
                $ar[$key]['current_number'] = $current_place[0]['current_number'];
                $ar[$key]['current_street'] = $current_place[0]['current_street'];
            }

            if ($search_term !== null) {
                foreach ($ar as $key => $value) {
                    $citrix_sql = "
                    SELECT
                        c.id,
                        c.citrix_number
                    FROM citrix c
                    JOIN asset_citrix ac ON c.id = ac.citrix_id
                    WHERE ac.asset_id = :asset;
                    ";
                    $citrix_data['asset'] = $value['asset_id'];
                    $citrixes = $this->getDbHelper()->querySelect($citrix_sql, $citrix_data);

                    foreach ($citrixes as $citrix) {
                        if (!isset($ar[$key]['citrix'])) {
                            $ar[$key]['citrix'] = '';
                        }
                        $ar[$key]['citrix'] .= $citrix['citrix_number'] . ', ';
                    }
                    if (isset($ar[$key]['citrix'])) {
                        $ar[$key]['citrix'] = substr($ar[$key]['citrix'], 0, -2);
                    }
                }
            }
        }

        return array_values($ar);
    }

    /**
     * @param string|null $search_term
     * @param int|null $asset
     * @param int|null $place
     * @param int|null $deliverer_person
     * @param int|null $receiver_person
     * @param int|null $pickup_person_id
     * @param int|null $pickup_responsible_person_id
     * @param bool $show_history
     * @param bool $show_future
     * @param string|null $from_date
     * @param string|null $until_date
     * @param bool $show_only_newest
     * @return int
     * @throws DatabaseError
     */
    public function count(
        ?string $search_term = null,
        ?int $asset = null,
        ?int $place = null,
        ?int $deliverer_person = null,
        ?int $receiver_person = null,
        ?int $pickup_person_id = null,
        ?int $pickup_responsible_person_id = null,
        bool $show_history = false,
        bool $show_future = false,
        ?string $from_date = null,
        ?string $until_date = null,
        bool $show_only_newest = false,
        ?string $lookup_date = null
    ) : int {
        $sql = "SELECT COUNT(pa.id), COUNT(pa.id) as total FROM places_assets pa
            LEFT OUTER JOIN asset a ON pa.asset_id = a.id
            LEFT OUTER JOIN citrix c on a.citrix_id = c.id
            LEFT OUTER JOIN place p on pa.place_id = p.id
            LEFT OUTER JOIN asset_user rpau on pa.receiver_person_id = rpau.id
            LEFT OUTER JOIN person rp on rpau.person_id = rp.id
            LEFT OUTER JOIN asset_user dpau on pa.deliverer_person_id = dpau.id
            LEFT OUTER JOIN person dp on dpau.person_id = dp.id
            LEFT OUTER JOIN asset_user ppau on pa.pickup_person_id = ppau.id
            LEFT OUTER JOIN person pp on ppau.person_id = pp.id
            LEFT OUTER JOIN asset_user prau on pa.pickup_responsible_person_id = prau.id
            LEFT OUTER JOIN person pr on prau.person_id = pr.id ";
        $data = [];
        if ($search_term === null) {
            if ($asset !== null ||
                $place !== null ||
                $deliverer_person !== null ||
                $receiver_person !== null ||
                $pickup_person_id !== null ||
                $pickup_responsible_person_id !== null ||
                !$show_history ||
                !$show_future ||
                $from_date !== null ||
                $until_date !== null ||
                $show_only_newest
            ) {
                $sql .= " WHERE ";
                if ($asset !== null) {
                    $sql .= "pa.asset_id = :asset AND ";
                    $data['asset'] = $asset;
                }
                if ($place !== null) {
                    $sql .= "pa.place_id = :place AND ";
                    $data['place'] = $place;
                }
                if ($deliverer_person !== null) {
                    $sql .= "pa.deliverer_person_id = :deliverer_person AND ";
                    $data['deliverer_person'] = $deliverer_person;
                }
                if ($receiver_person !== null) {
                    $sql .= "pa.receiver_person_id = :receiver_person AND ";
                    $data['receiver_person'] = $receiver_person;
                }
                if ($pickup_person_id !== null) {
                    $sql .= "pa.pickup_person_id = :pickup_person_id AND ";
                    $data['pickup_person_id'] = $pickup_person_id;
                }
                if ($pickup_responsible_person_id !== null) {
                    $sql .= "pa.pickup_responsible_person_id = :pickup_responsible_person_id AND ";
                    $data['pickup_responsible_person_id'] = $pickup_responsible_person_id;
                }
                if ($lookup_date === null) {
                    if (!$show_history && !$show_future) {
                        $sql .= " ( pa.until_datetimez IS NULL ) AND ";
                    } elseif (!$show_future) {
                        $sql .= " (pa.from_datetimez < NOW() AND pa.until_datetimez IS NULL) AND ";
                    } else {
                        if (!$show_history) {
                            $sql .= " (pa.from_datetimez > NOW() AND pa.until_datetimez IS NULL) AND ";
                        }
                    }
                    if ($show_only_newest) {
                        $sql .= " (pa.until_datetimez IS NULL) AND ";
                    }
                    if ($from_date !== null) {
                        $sql .= " (pa.from_datetimez > :from_date) AND ";
                        $data['from_date'] = $from_date;
                    }
                    if ($until_date !== null) {
                        $sql .= " (pa.from_datetimez < :until_date) AND ";
                        $data['until_date'] = $until_date;
                    }
                } elseif ($lookup_date !== null) {
                    $sql .= " ((pa.from_datetimez::date = :lookup_date_from) OR (pa.until_datetimez::date = :lookup_date_until)) AND ";
                    $data['lookup_date_from'] = $lookup_date;
                    $data['lookup_date_until'] = $lookup_date;
                }
                $sql = substr($sql, 0, -4);
            }
            $sql .= ";";
        } else {
            $sql .= " WHERE ";
            if ($asset !== null ||
                $place !== null ||
                $deliverer_person !== null ||
                $receiver_person !== null ||
                $pickup_person_id !== null ||
                $pickup_responsible_person_id !== null ||
                !$show_history ||
                !$show_future ||
                $from_date !== null ||
                $until_date !== null ||
                $show_only_newest
            ) {
                if ($asset !== null) {
                    $sql .= "pa.asset_id = :asset AND ";
                    $data['asset'] = $asset;
                }
                if ($place !== null) {
                    $sql .= "pa.place_id = :place AND ";
                    $data['place'] = $place;
                }
                if ($deliverer_person !== null) {
                    $sql .= "pa.deliverer_person_id = :deliverer_person AND ";
                    $data['deliverer_person'] = $deliverer_person;
                }
                if ($receiver_person !== null) {
                    $sql .= "pa.receiver_person_id = :receiver_person AND ";
                    $data['receiver_person'] = $receiver_person;
                }
                if ($pickup_person_id !== null) {
                    $sql .= "pa.pickup_person_id = :pickup_person_id AND ";
                    $data['pickup_person_id'] = $pickup_person_id;
                }
                if ($pickup_responsible_person_id !== null) {
                    $sql .= "pa.pickup_responsible_person_id = :pickup_responsible_person_id AND ";
                    $data['pickup_responsible_person_id'] = $pickup_responsible_person_id;
                }
                if (!$show_history && !$show_future) {
                    $sql .= " ( pa.until_datetimez IS NULL ) AND ";
                } elseif (!$show_future) {
                    $sql .= " (pa.from_datetimez < NOW() AND pa.until_datetimez IS NULL) AND ";
                } else if (!$show_history) {
                    $sql .= " (pa.from_datetimez > NOW() AND pa.until_datetimez IS NULL) AND ";
                }
                if ($show_only_newest) {
                    $sql .= " (pa.until_datetimez IS NULL) AND ";
                }
                if ($from_date !== null) {
                    $sql .= " (pa.from_datetimez > :from_date) AND ";
                    $data['from_date'] = $from_date;
                }
                if ($until_date !== null) {
                    $sql .= " (pa.from_datetimez < :until_date) AND ";
                    $data['until_date'] = $until_date;
                }
                if ($lookup_date !== null) {
                    $sql .= " ((pa.from_datetimez::date = :lookup_date_from) OR (pa.until_datetimez::date = :lookup_date_until)) AND ";
                    $data['lookup_date_from'] = $lookup_date;
                    $data['lookup_date_until'] = $lookup_date;
                }
            }
            $sql .= "
                ((pa.text ILIKE :search_term_w_1) OR
                (a.name ILIKE :search_term_w_2) OR
                (a.type ILIKE :search_term_w_4) OR
                (a.serial ILIKE :search_term_w_5) OR
                (p.name ILIKE :search_term_w_6) OR
                (p.city ILIKE :search_term_w_7) OR
                (rp.last_name ILIKE :search_term_w_8) OR
                (rp.first_name ILIKE :search_term_w_9) OR
                (dp.last_name ILIKE :search_term_w_10) OR
                (dp.first_name ILIKE :search_term_w_11) OR
                (pp.last_name ILIKE :search_term_w_12) OR
                (pp.first_name ILIKE :search_term_w_13) OR
                (pr.last_name ILIKE :search_term_w_14) OR
                (c.citrix_number ILIKE :search_term_w_15) OR
                (pa.external_person ILIKE :search_term_w_16) OR
                (pr.first_name ILIKE :search_term_w_3)); ";
            for ($i = 1; $i <= 16; $i++) {
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

    /**
     * @param int $offset
     * @param int $per_page
     * @param string|null $search_term
     * @return array
     * @throws DatabaseError
     */
    public function listPlacesAssetsExternalPerson(int $offset, int $per_page, ?string $search_term)
    {
        $sql = "SELECT pa.external_person, pa.external_person ";
        if ($search_term === null) {
            $sql .= " FROM places_assets pa
                      WHERE pa.external_person IS NOT NULL
                      GROUP BY pa.external_person
                      ORDER BY pa.external_person LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
        } else {
            $sql .= " ,
             CASE
                    WHEN (pa.external_person ILIKE :search_term_1) THEN 1000 
                    WHEN (pa.external_person ILIKE :search_term_suffix_1) THEN 200
                    WHEN (pa.external_person ILIKE :search_term_prefix_1) THEN 180
                    WHEN (pa.external_person ILIKE :search_term_both_1) THEN 80
                    ELSE 0    
             END as weight ";
            $sql .= " FROM places_assets pa ";
            $sql .= " WHERE (pa.external_person ILIKE :search_term_w_1) AND pa.external_person IS NOT NULL ";
            $sql .= " ORDER BY pa.external_person LIMIT :per_page OFFSET :offset;";
            $data = [
                'per_page' => $per_page,
                'offset' => $offset,
            ];
            for ($i = 1; $i <= 1; $i++) {
                $data['search_term_' . $i] = $search_term;
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
                $data['search_term_suffix_' . $i] = $search_term . '%';
                $data['search_term_prefix_' . $i] = '%' . $search_term;
                $data['search_term_both_' . $i] = '%' . $search_term . '%';
            }
        }
        return $this->getDbHelper()->querySelect($sql, $data);
    }

    /**
     * @param string|null $search_term
     * @return int
     * @throws DatabaseError
     */
    public function countPlacesAssetsExternalPerson(?string $search_term)
    {
        $data = [];
        $sql = "SELECT COUNT(pa.external_person), COUNT(pa.external_person) as total FROM places_assets pa WHERE pa.external_person IS NOT NULL ";
        if ($search_term === null) {
            $sql .= " ";
        } else {
            $sql .= " AND (pa.external_person ILIKE :search_term_w_1) ";
            for ($i = 1; $i <= 1; $i++) {
                $data['search_term_w_' . $i] = '%' . $search_term . '%';
            }
        }
        $sql .= " GROUP BY pa.external_person; ";
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        $ar = array_pop($ar);
        if (isset($ar) && isset($ar['total'])) {
            return (int)$ar['total'];
        } else {
            return 0;
        }
    }

    public function listByExternalPerson(int $offset, int $per_page, string $external_user)
    {
        $data = [];
        $sql = "
            SELECT 
                pa.id,
                pa.id,
                pa.asset_id,
                pa.place_id,
                pa.deliverer_person_id,
                pa.receiver_person_id,
                pa.pickup_person_id,
                pa.pickup_responsible_person_id,
                pa.automatic_callback,
                pa.text,
                pa.delivered,
                pa.delivery_datetimez,
                pa.from_datetimez,
                pa.until_datetimez,
                pa.pickup_datetimez,
                pa.external_person,
                a.name,
                a.type,
                a.serial,
                a.out_of_order,
                a.active,
                c.citrix_number,
                p.name as place_name,
                p.city,
                p.postcode,
                p.number,
                p.street,
                rp.last_name as rp_last_name,
                rp.first_name as rp_first_name,
                dp.last_name as dp_last_name,
                dp.first_name as dp_first_name,
                pp.last_name as pp_last_name,
                pp.first_name as pp_first_name,
                pr.last_name as pr_last_name,
                pr.first_name as pr_first_name
            FROM places_assets pa
            LEFT OUTER JOIN asset a ON pa.asset_id = a.id
            LEFT OUTER JOIN asset_citrix ac ON ac.asset_id = a.id 
            LEFT OUTER JOIN citrix c on ac.citrix_id = c.id
            LEFT OUTER JOIN place p on pa.place_id = p.id
            LEFT OUTER JOIN asset_user rpau on pa.receiver_person_id = rpau.id
            LEFT OUTER JOIN person rp on rpau.person_id = rp.id
            LEFT OUTER JOIN asset_user dpau on pa.deliverer_person_id = dpau.id
            LEFT OUTER JOIN person dp on dpau.person_id = dp.id
            LEFT OUTER JOIN asset_user ppau on pa.pickup_person_id = ppau.id
            LEFT OUTER JOIN person pp on ppau.person_id = pp.id
            LEFT OUTER JOIN asset_user prau on pa.pickup_responsible_person_id = prau.id
            LEFT OUTER JOIN person pr on prau.person_id = pr.id
            WHERE pa.external_person = :external_person
            ORDER BY pa.from_datetimez
            OFFSET :offset LIMIT :per_page;";
        $data['external_person'] = $external_user;
        $data['offset'] = $offset;
        $data['per_page'] = $per_page;

        return $this->getDbHelper()->querySelect($sql, $data);
    }

    public function countByExternalPerson(string $external_user)
    {
        $data = [];
        $sql = "SELECT COUNT(pa.external_person), COUNT(pa.external_person) as total 
            FROM places_assets pa
            WHERE pa.external_person = :external_person
           ";

        $data['external_person'] = $external_user;
        $ar = $this->getDbHelper()->querySelect($sql, $data);
        $ar = array_pop($ar);
        if (isset($ar) && isset($ar['total'])) {
            return (int)$ar['total'];
        } else {
            return 0;
        }
    }
}
