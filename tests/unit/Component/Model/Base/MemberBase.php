<?php
declare(strict_types=1);

namespace Imi\Test\Component\Model\Base;

use Imi\Model\Model as Model;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Table;
use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\Entity;

/**
 * tb_member 基类
 * @Entity
 * @Table(name="tb_member", id={"id"})
 * @DDL("CREATE TABLE `tb_member` (   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,   `username` varchar(32) NOT NULL COMMENT '用户名',   `password` varchar(255) NOT NULL COMMENT '密码',   PRIMARY KEY (`id`) USING BTREE ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT")
 * @property int|null $id 
 * @property string|null $username 用户名
 * @property string|null $password 密码
 */
abstract class MemberBase extends Model
{
    /**
     * id
     * @Column(name="id", type="int", length=10, accuracy=0, nullable=false, default="", isPrimaryKey=true, primaryKeyIndex=0, isAutoIncrement=true)
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * 获取 id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * 赋值 id
     * @param int|null $id id
     * @return static
     */
    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 用户名
     * username
     * @Column(name="username", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $username = null;

    /**
     * 获取 username - 用户名
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * 赋值 username - 用户名
     * @param string|null $username username
     * @return static
     */
    public function setUsername(?string $username)
    {
        if (is_string($username) && mb_strlen($username) > 32)
        {
            throw new \InvalidArgumentException('The maximum length of $username is 32');
        }
        $this->username = $username;
        return $this;
    }

    /**
     * 密码
     * password
     * @Column(name="password", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $password = null;

    /**
     * 获取 password - 密码
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * 赋值 password - 密码
     * @param string|null $password password
     * @return static
     */
    public function setPassword(?string $password)
    {
        if (is_string($password) && mb_strlen($password) > 255)
        {
            throw new \InvalidArgumentException('The maximum length of $password is 255');
        }
        $this->password = $password;
        return $this;
    }

}
