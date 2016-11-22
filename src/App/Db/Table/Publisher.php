<?php
/**
 * Table Definition for record
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2010.
 * Copyright (C) University of Freiburg 2014.
 * Copyright (C) The National Library of Finland 2015.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  Db_Table
 * @author   Markus Beh <markus.beh@ub.uni-freiburg.de>
 * @author   Ere Maijala <ere.maijala@helsinki.fi>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org Main Site
 */
namespace App\Db\Table;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;
/**
 * Table Definition for record
 *
 * @category VuFind
 * @package  Db_Table
 * @author   Markus Beh <markus.beh@ub.uni-freiburg.de>
 * @author   Ere Maijala <ere.maijala@helsinki.fi>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org Main Site
 */
class Publisher extends \Zend\Db\TableGateway\TableGateway
{
    /**
     * Constructor
     */
    public function __construct($adapter)
    {
        parent::__construct('publisher', $adapter);
    }
    
    /**
     * Update an existing entry in the record table or create a new one
     *
     * @param string $id      Record ID
     * @param string $source  Data source
     * @param string $rawData Raw data from source
     *
     * @return Updated or newly added record
     */
    public function insertRecords($name)
    {
        $this->insert(
            [
            'name' => $name
            ]
        );
    }
    
    public function findRecords($name)
    {
        $select = $this->sql->select()->where(['name' => $name]);
        $paginatorAdapter = new DbSelect($select, $this->adapter);
        return new Paginator($paginatorAdapter);
    }
    
    public function findRecord()
    {
        //$select = $this->sql->select()->columns(array('name'));
        //$result = $select->execute();
        
        $stmt = $this->sql->select()->where(['name' => 'trp']);
        //$stmt->execute();    
    }
    
    /*public function findRecords($name)
    {
        if (!empty($name)) {

            $select = $this->tableGateway->getSql()->select();
            $select->columns(["name"]
            )->where([
                "publisher.name" => $name
            ]);
            var_dump($this->tableGateway->selectWith($select));
            return $this->tableGateway->selectWith($select);
        }
    } */
    
    public function updateRecord($id, $name)
    {
        $this->update(
            [
                'name' => $name
            ],
            ['id' => $id]
        );
    }
    
    public function deleteRecord($id)
    {
        $this->delete(['id' => $id]);
        //$this->tableGateway->delete(['id' => $id]);
    }
}
