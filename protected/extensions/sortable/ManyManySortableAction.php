<?php

class ManyManySortableAction extends CAction
{

	public function run()
	{
		if(isset($_GET['rte']))
		{
			$this->tInP($_GET['rte']);
			Y::end();
		}
		
		$model = new $_POST['model'];
		$cat_id = $_POST['cat_id'];

		if(isset($_POST['el'], $_POST['cat_id']))
		{
			list($prev, $curr, $next) = explode('.', $_POST['el']);

			$model->setOrderPositions($prev, $curr, $next, $cat_id);
			
			$this->outPocket($this->getName($cat_id), $curr);
		}
		
		if(isset($_POST['in_pocket']))
		{
			$this->inPocket($this->getName($cat_id));
		}
		
		if(isset($_POST['out_pocket']))
		{
			$this->outPocket($this->getName($cat_id));
		}
		
	}
	
	private function tInP($cat_id)
	{
		$this->inPocket($this->getName($cat_id), 2);
	}

	private function getName($cat_id)
	{
		return "sortable_pocket_{$cat_id}";
	}

	private function inPocket($name, $v=null)
	{
		$val= $v ? $v : intval($_POST['in_pocket']);
		if(Yii::app()->user->hasState($name))
		{
			$arr = Yii::app()->user->getState($name);
			if(!in_array($val, $arr))
			{
				Yii::app()->user->setState($name, array_merge($arr, array($val)));
			}
		}else{
			Yii::app()->user->setState($name, array($val));
		}
	}

	private function outPocket($name, $v=null)
	{
		$val=$v ? $v : intval($_POST['out_pocket']);
		
		if(Yii::app()->user->hasState($name))
		{
			$arr = Yii::app()->user->getState($name);
			if(in_array($val, $arr))
			{
				$key = array_search($val, $arr);
				unset($arr[$key]);

				$arr = $arr ? array_values($arr) :null;
				Yii::app()->user->setState($name, $arr);
			}
		}
	}
}
