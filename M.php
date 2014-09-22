<?php
class M
{
	protected $_command = null;
	protected $_table = null;
	protected $_condition = null;
	protected $_params = array();
	
	public function __construct()
	{
		$this->_command = Yii::app()->db->createCommand();
		$this->_command->reset();
	}

	public function reset()
	{
		$this->_command->reset();
	}

	public function table($tables)
	{
		$this->reset();
		$this->_command->from($tables);
		$this->_table = $tables;
		return $this;
	}
	
	public function leftJoin($table, $conditions = null, $params=array())
	{
		if(is_array($table))
		{
			foreach($table as $jk=>$jv)
			{
				$param = array();
				if(is_array($jv))
				{
					$condition = Util::getArray($jv, 0);
					$param = Util::getArray($jv, 1, array());
				}
				else
				{
					$condition = $jv;
				}
				$this->leftJoin($jk, $condition, $param);
			}
		}
		else
		{
			$this->_command->leftJoin($table, $conditions, $params);
		}
		return $this;
	}

	public function fields($fields='*', $option='')
	{
		$this->_command->select($fields, $option);
		return $this;
	}

	public function where($where, $param=array())
	{
		$this->_command->where($where, $param);
		$this->_condition = $where;
		$this->_params = $param;
		return $this;
	}

	public function find()
	{
		return $this->_command->queryRow();
	}

	public function select()
	{
		return $this->_command->queryAll();
	}

	public function count()
	{
		$res = $this->fields('count(*) as c')->find();
		return intval($res['c']);
	}

	public function delete()
	{
		return $this->_command->delete($this->_table, $this->_condition, $this->_params);
	}

	public function group($column)
	{
		$this->_command->group($column);
		return $this;
	}

	public function order($column)
	{
		$this->_command->order($column);
		return $this;
	}
}
