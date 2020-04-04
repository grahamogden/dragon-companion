<?php
namespace App\Model\Entity;

use Cake\Collection\Collection;
use Cake\ORM\Entity;

/**
 * Clan Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property \App\Model\Entity\User[] $users
 */
class Clan extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name'         => true,
        'description'  => true,
        'users'        => true,
        'users_string' => true,
    ];

    /**
     * Returns a comma separated list of the user's usernames for the clan
     * 
     * @return string
     */
    protected function _getUsersString(): string
    {
        if (isset($this->_properties['users_string'])) {
            return $this->_properties['users_string'];
        }

        if (empty($this->users)) {
            return '';
        }

        $users = new Collection($this->users);
        $str   = $users->reduce(function ($string, $user) {
            return $string . $user->username . ', ';
        }, '');

        return $str;
    }
}
