<?php

namespace Zwuiix\AdvancedRank\rank;

class Rank
{

    /**
     * @param string $name <code>Name of Rank<code>
     * @param int $priority <code>Priority of Rank<code>
     * @param array $permissions <code>Permissions of Rank<code>
     * @param string $chat <code>Chat format of Rank<code>
     * @param string $nameTag <code>Tag format of Rank<code>
     */
    public function __construct(
        protected string $name,
        protected int $priority,
        protected array $permissions,
        private string $chat,
        private string $nameTag
    )
    {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }

    /**
     * @param string $permission
     */
    public function addPermission(string $permission): void
    {
        $this->permissions[] = $permission;
    }

    /**
     * @param string $permission
     */
    public function removePermission(string $permission): void
    {
        if(isset($this->permissions[$permission])){
            unset($this->permissions[$permission]);
        }
    }

    /**
     * @return string
     */
    public function getChat(): string
    {
        return $this->chat;
    }

    /**
     * @param string $chat
     */
    public function setChat(string $chat): void
    {
        $this->chat = $chat;
    }

    /**
     * @return string
     */
    public function getNameTag(): string
    {
        return $this->nameTag;
    }

    /**
     * @param string $nameTag
     */
    public function setNameTag(string $nameTag): void
    {
        $this->nameTag = $nameTag;
    }
}