<?php
declare(strict_types=1);

namespace AssetManager\Helper;

use AssetManager\Error\DatabaseError;
use AssetManager\Error\UniqueError;
use PDO;
use PDOException;

class DbHelper
{
    protected ?string $type;
    protected ?string $host;
    protected ?string $name;
    protected ?string $password;
    protected ?string $database;
    protected ?PDO $connection;

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return DbHelper
     */
    public function setHost(string $host): DbHelper
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DbHelper
     */
    public function setName(string $name): DbHelper
    {
        $this->name = $name;
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
     * @return DbHelper
     */
    public function setPassword(string $password): DbHelper
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @param string $database
     * @return DbHelper
     */
    public function setDatabase(string $database): DbHelper
    {
        $this->database = $database;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return DbHelper
     */
    public function setType(string $type): DbHelper
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @throws DatabaseError
     */
    protected function connect()
    {
        try {
            $this->connection = new PDO($this->getType() . ":host=" . $this->getHost() . ";dbname=" . $this->getDatabase(), $this->getName(), $this->getPassword());
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new DatabaseError('connection not successful' . $e->getMessage());
        }
    }

    protected function disconnect()
    {
        $this->connection = null;
    }

    /**
     * @param string $sql
     * @param array $data
     * @return array
     * @throws DatabaseError
     */
    public function querySelect(string $sql, array $data = [])
    {
        $return = [];
        $this->connect();

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);

            // set the resulting array to associative
            if ($stmt->setFetchMode(PDO::FETCH_ASSOC)) {
                $return = $stmt->fetchAll(PDO::FETCH_UNIQUE);
            }
        } catch (PDOException $e) {
            throw new DatabaseError('Database: Could not select!' . $e->getMessage());
        }
        $this->disconnect();

        return $return;
    }

    /**
     * @param string $sql
     * @param array $data
     * @return int
     * @throws DatabaseError
     */
    public function queryUpdate(string $sql, array $data)
    {
        $return = 0;
        $this->connect();
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);

            $return = $stmt->rowCount();

            if ($return === false) {
                throw new DatabaseError('Database: SQL statement not successful!');
            }
        } catch (PDOException $e) {
            throw new DatabaseError('Database: Could not change!' . $e->getMessage());
        }
        $this->disconnect();
        return $return;
    }

    /**
     * @param string $sql
     * @param array $data
     * @return int
     * @throws DatabaseError
     */
    public function queryDelete(string $sql, array $data)
    {
        $return = 0;
        $this->connect();
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);

            $return = $stmt->rowCount();

            if ($return === false) {
                throw new DatabaseError('Database: SQL statement not successful!');
            }
        } catch (PDOException $e) {
            throw new DatabaseError('Database: Could not change!' . $e->getMessage());
        }
        $this->disconnect();
        return $return;
    }

    /**
     * @param string $sql
     * @param array $data
     * @return int
     * @throws DatabaseError
     */
    public function queryInsert(string $sql, array $data)
    {
        $return = 0;
        $this->connect();
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);

            $return = $this->connection->lastInsertId();

            if ($return === false) {
                throw new DatabaseError('Database: SQL statement not successful!');
            }
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Unique violation') !== false) {
                preg_match('/Key \((\w*)\)/', $e->getMessage(), $matches);
                throw new UniqueError($matches[1]);
            } else {
                throw new DatabaseError('Database: Could not change!' . $e->getMessage());
            }
        }
        $this->disconnect();
        return $return;
    }
}
