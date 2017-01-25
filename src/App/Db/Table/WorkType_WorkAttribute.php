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
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

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
class WorkType_WorkAttribute extends \Zend\Db\TableGateway\TableGateway
{
    /**
     * Constructor
     */
    public function __construct($adapter)
    {
        parent::__construct('worktype_workattribute', $adapter);
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
	
	public function displayRanks($id)
	{		
		$select = $this->sql->select();
		$select->join('workattribute', 'worktype_workattribute.workattribute_id = workattribute.id', array('field'), 'inner');
		$select->where(['worktype_id' => $id]);
		$select->order('rank');

        $paginatorAdapter = new Paginator(new DbSelect($select, $this->adapter));
		$cnt = $paginatorAdapter->getTotalItemCount();

		return $paginatorAdapter;
	}
	
	public function getWorkAttributeQuery($id)
	{
		//echo $id;
		$subselect = $this->sql->select();
		$subselect->join('workattribute', 'worktype_workattribute.workattribute_id = workattribute.id', array('field'), 'inner');
		$subselect->where(['worktype_id' => $id]);
		$subselect->order('rank');
		
		$paginatorAdapter = new Paginator(new DbSelect($subselect, $this->adapter));
		$cnt = $paginatorAdapter->getTotalItemCount();
		//echo "selected field count is $cnt <br />";
		$paginatorAdapter->setDefaultItemCountPerPage($cnt);
		$fieldRows = [];
		foreach($paginatorAdapter as $row) :
				$fieldRows[] = $row['field'];
		endforeach;
		//print_r($fieldRows);
		return $fieldRows;
	}
	
	public function darrowUpdate($wkt_id,$wat_id,$wkt_wkat_rank,$wkat_field) 
	{  
        $this->update(
            [
                'rank' => new Expression('rank - 1'),
            ],
            ['worktype_id' => $wkt_id, 'rank' => $wkt_wkat_rank+1]
        );
		$this->update(
			[
				'rank' => new Expression('rank + 1'),
			],
			['worktype_id' => $wkt_id, 'workattribute_id' => $wat_id]
		);
	}
	
	public function uarrowUpdate($wkt_id,$wat_id,$wkt_wkat_rank,$wkat_field) 
	{
        $this->update(
            [
                'rank' => new Expression('rank + 1'),
            ],
            ['worktype_id' => $wkt_id, 'rank' => $wkt_wkat_rank-1]
        );
		$this->update(
			[
				'rank' => new Expression('rank - 1'),
			],
			['worktype_id' => $wkt_id, 'workattribute_id' => $wat_id]
		);
	}
	
	public function UpdateWorkTypeAttributeRank($wkt_id,$wkat_ids,$selected_wkat)
	{
		//print_r($ranks);
		$callback = function($select) use ($wkt_id,$ranks) {
			$select->columns(['*']);
			//$select->where->in('rank', $ranks);
			$select->where->equalTo('worktype_id', $wkt_id);
			$select->order('rank');
		};
		$rows = $this->select($callback)->toArray();
		//echo '<pre>';print_r($rows);echo '</pre>';
		$cnt = count($rows);
		//echo "no of attributes added to worktype - $cnt <br />";
		$count = count($wkat_ids);
		//echo "selected attributes to add - $count <br />";
		
		//echo "id of attribute(s) selected to add";
		//echo '<pre>';print_r($wkat_ids);echo '</pre>';
		
		//echo "selected_wkat ids is";
		//echo '<pre>';print_r($selected_wkat);echo '</pre>';
		for($i=0;$i<$cnt;$i++) {
			$this->update(
            [
                'rank' => new Expression('rank + ' . $count),
            ],
			['workattribute_id' => $selected_wkat[$i]]
			); 
			//echo "$i id is $selected_wkat[$i] <br />";
		}
	}
	
	public function addAttributeToWorkType($wkt_id,$wkat_ids)
	{
		$cnt = count($wkat_ids);
		for($i=0;$i<$cnt;$i++) {
			$this->insert(
            [
				'worktype_id' => $wkt_id,
				'workattribute_id' => $wkat_ids[$i],
				'rank' => $i,
            ]
			); 
		}
	}
	
	public function deleteAttributeFromWorkType($wkt_id,$wkat_ids)
    {
        /*echo "from delete func: worktype id is $wkt_id <br />";
		echo "from del function: work attrs to delete: <br />";
		echo '<pre>';print_r($wkat_ids);echo '</pre>'; */
		$callback = function($select) use ($wkt_id, $wkat_ids) {
            $select->where->in('workattribute_id', $wkat_ids);
            $select->where->equalTo('worktype_id', $wkt_id);
			//$select->order('rank');
        };     
        $rows = $this->select($callback)->toArray();
		/*echo "from del func - retrieved rows: <br />";
		echo '<pre>';print_r($rows);echo '</pre>';*/
        $cnt = count($rows);
        for($i=0;$i<$cnt;$i++) {
            $this->delete($callback);
        }
    }
	
	public function updateWorkTypeAttributeRank_Remove($wkt_id)
	{
		//echo "from update func: worktype id is $wkt_id <br />";
		$callback = function($select) use ($wkt_id) {            
            $select->where->equalTo('worktype_id', $wkt_id);
			$select->order('rank');
        };     
        $rows = $this->select($callback)->toArray();
		/*echo "from update func - retrieved rows: <br />";
		echo '<pre>';print_r($rows);echo '</pre>';*/
        $cnt = count($rows);
        for($i=0;$i<$cnt;$i++) {
			$this->update(
            [
                'rank' => $i,
            ],
			['rank' => $rows[$i]['rank']]			
			); 
			//echo "rank to be updated is " . $rows[$i]['rank'] . "<br />";
			//echo "rank will be updated to: $i <br />";
        }
	}
	
	public function countWorkTypesByWorkAttributes($wkat_id)
	{		
		$callback = function ($select) use($wkat_id){
                $select->columns(
				[
					'count_worktypes' => new Expression(
                    'COUNT(?)', ['worktype_id'],
                    [Expression::TYPE_IDENTIFIER]
					)
				]
				);			
				$select->where->equalTo('workattribute_id', $wkat_id);
        };

        return $this->select($callback)->toArray();
	}
	
	public function deleteRecordByWorkType($wkt_id)
	{
		$callback = function($select) use($wkt_id) {
			$select->where->equalTo('worktype_id', $wkt_id);
		};
		$rows = $this->select($callback)->toArray();
		$cnt = count($rows);
		for($i=0;$i<$cnt;$i++) {
			$this->delete($callback);
		}
	}
	
	public function deleteAttributeFromAllWorkTypes($wkat_id)
	{
		$callback = function($select) use($wkat_id) {
			$select->where->equalTo('workattribute_id', $wkat_id);
		};
		$rows = $this->select($callback)->toArray();
		$cnt = count($rows);
		for($i=0;$i<$cnt;$i++) {
			$this->delete($callback);
		}
	}
}
