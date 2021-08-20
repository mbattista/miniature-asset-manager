<?php
declare(strict_types=1);

namespace AssetManager\Traits;

use DateTime;

trait TimestampTrait
{
    protected DateTime $created;
    protected ?DateTime $updated;

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime|null $updated
     * @return $this
     */
    public function setUpdated(?DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }
}
