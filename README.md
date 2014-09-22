Yii_M
=====

类似于ThinkPHP的M()方法。做链式操作用的。

把此文件放在protected/components/下面。
在使用的时候，
  $model = new M();
  $data = $model->table('tablename')->where($map)->fields($fields)->find();
  $list = $model->table('tablename as a')->count();
  
各种操作正在更新中。。。
