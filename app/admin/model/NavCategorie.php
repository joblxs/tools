<?php
namespace app\admin\model;

use think\Model;

class NavCategorie extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'nav_categorie';
    // 设置时间戳字段名
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';
    protected $deleteTime = 'delete_at';

    // 分类管理列表
    public static function getCateList(){
        $cateList = self::where('is_delete', 0)
            ->order(['sort' => 'desc', 'id' => 'asc'])
            ->select();
        return $cateList;
    }

    // 添加/修改页面上级分类选择
    public static function getPidCateList() {
        $list = self::field('id,pid,title')
            ->where([
                ['is_delete', '=', 0],
                ['pid', '=', 0],
            ])->order(['sort' => 'desc', 'id' => 'asc'])
            ->select()
            ->toArray();
        foreach ($list as $key => $vo) {
            $repeatString = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $markString   = str_repeat("{$repeatString}├{$repeatString}", 1);
            $vo['title']  = $markString . $vo['title'];
            $list[$key] = $vo;
        }
        $pidCateList = array_merge([[
            'id'    => 0,
            'pid'   => 0,
            'title' => '顶级分类',
        ]], $list);
        return $pidCateList;
    }
}