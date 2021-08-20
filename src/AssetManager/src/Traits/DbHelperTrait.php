<?php
declare(strict_types=1);

namespace AssetManager\Traits;

use AssetManager\Helper\DbHelper;

trait DbHelperTrait
{
    protected DbHelper $db_helper;

    /**
     * @return DbHelper
     */
    public function getDbHelper(): DbHelper
    {
        return $this->db_helper;
    }

    /**
     * @param DbHelper $db_helper
     */
    public function setDbHelper(DbHelper $db_helper)
    {
        $this->db_helper = $db_helper;
        return $this;
    }
}
