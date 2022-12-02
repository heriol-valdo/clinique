<?php
/**
 * Created by PhpStorm.
 * User: Youssef
 * Date: 14/05/2020
 * Time: 03:08
 */

namespace Projet\Database;


use Projet\Model\Table;


class products extends  Table
{
    protected static $table = 'products';

    public static function save($productname,$category_id,$slug,$description,
                                $price,$offer_price,$sub_category,$sku,$supplier_code,
                                $discount,$tags,$package_type,$length,$width,$height,$weight,$weightOz,
                                $freightClass,$nmfcCode,$trending,$deal,$hot,$id=null){
        $sql = 'INSERT INTO ';
        $baseSql = self::getTable().' SET productname= :productname,category_id= :category_id,slug= :slug,hot= :hot,
                                description= :description,price= :price,offer_price= :offer_price,sub_category= :sub_category,
                                sku= :sku,supplier_code= :supplier_code,discount= :discount,tags= :tags,trending= :trending,
                                package_type= :package_type,length= :length,width= :width,height= :height,weight= :weight,
                                weightOz= :weightOz,freightClass= :freightClass,nmfcCode= :nmfcCode,deal= :deal';
        $baseParam = [':productname' =>$productname,':category_id'=>$category_id,':trending'=>$trending,':slug'=>$slug,
                    ':description'=>$description,':price'=>$price,':offer_price'=>$offer_price,':sub_category'=>$sub_category,
                    ':sku'=>$sku,':supplier_code'=>$supplier_code,':discount'=>$discount,':tags'=>$tags,':deal'=>$deal,
                    ':package_type'=>$package_type,':length'=>$length,':width'=>$width,':height'=>$height,':weight'=>$weight,
                    ':weightOz'=>$weightOz,':freightClass'=>$freightClass,':nmfcCode'=>$nmfcCode,':hot'=>$hot];
        if(isset($id)){
            $sql = 'UPDATE ';
            $baseSql .= ' WHERE productid = :id';
            $baseParam [':id'] = $id;
        }
        return self::query($sql.$baseSql, $baseParam, true, true);
    }

    public static function bySku($ref){
        $sql =self::selectString().' WHERE sku = :ref';
        $param = [':ref'=>($ref)];
        return self::query($sql,$param,true);
    }

    public static function byNom($val){
        $sql =self::selectString().' WHERE productname = :val';
        $param = [':val'=>($val)];
        return self::query($sql,$param,true);
    }


    public static function find($id){
        $sql = static::selectString().' WHERE productid = :id';
        return self::query($sql,[':id'=>$id],true);
    }

    public static function setEtat($etat,$id){
        $sql = 'UPDATE '.self::getTable().' SET status = :etat WHERE productid = :id';
        $param = [':etat'=>($etat),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setStock($nbre,$id){
        $sql = 'UPDATE '.self::getTable().' SET qty = :nbre WHERE productid = :id';
        $param = [':nbre'=>($nbre),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function setImage($image,$id){
        $sql = 'UPDATE '.self::getTable().' SET image = :image WHERE productid = :id';
        $param = [':image'=>($image),':id'=>($id)];
        return self::query($sql,$param,true,true);
    }

    public static function countBySearchType($productname=null,$category_id=null,$sub_category=null,$package_type=null,$stock=null,$status=null){
        $count = 'SELECT COUNT(*) AS Total, SUM(qty) AS somme FROM '.self::getTable();
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($productname)){
            $tproductname = ' AND (productname LIKE :productname OR sku LIKE :productname)';
            $tab[':productname'] = '%'.$productname.'%';
        }else{
            $tproductname = '';
        }
        if(isset($category_id)){
            $tcategory_id = ' AND category_id = :category_id';
            $tab[':category_id'] = $category_id;
        }else{
            $tcategory_id = '';
        }
        if(isset($sub_category)){
            $tsub_category = ' AND sub_category = :sub_category';
            $tab[':sub_category'] = $sub_category;
        }else{
            $tsub_category = '';
        }
        if(isset($package_type)){
            $tpackage_type = ' AND package_type = :package_type';
            $tab[':package_type'] = $package_type;
        }else{
            $tpackage_type = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($stock)){
            $tstock = $stock==2?' AND qty = 0':' AND qty > 0';
        }else{
            $tstock = '';
        }
        return self::query($count.$where.$tproductname.$tstock.$tcategory_id.$tpackage_type.$tstatus.$tsub_category,$tab,true);
    }

    public static function searchType($nbreParPage=null,$pageCourante=null,$productname=null,$category_id=null,$sub_category=null,$package_type=null,$stock=null,$status=null){
        $limit = ' ORDER BY productname';
        $limit .= (isset($nbreParPage)&&isset($pageCourante))?' LIMIT '.(($pageCourante-1)*$nbreParPage).','.$nbreParPage:'';
        $where = ' WHERE 1 = 1';
        $tab = [];
        if(isset($productname)){
            $tproductname = ' AND (productname LIKE :productname OR sku LIKE :productname)';
            $tab[':productname'] = '%'.$productname.'%';
        }else{
            $tproductname = '';
        }
        if(isset($category_id)){
            $tcategory_id = ' AND category_id = :category_id';
            $tab[':category_id'] = $category_id;
        }else{
            $tcategory_id = '';
        }
        if(isset($sub_category)){
            $tsub_category = ' AND sub_category = :sub_category';
            $tab[':sub_category'] = $sub_category;
        }else{
            $tsub_category = '';
        }
        if(isset($package_type)){
            $tpackage_type = ' AND package_type = :package_type';
            $tab[':package_type'] = $package_type;
        }else{
            $tpackage_type = '';
        }
        if(isset($status)){
            $tstatus = ' AND status = :status';
            $tab[':status'] = $status;
        }else{
            $tstatus = '';
        }
        if(isset($stock)){
            $tstock = $stock==2?' AND qty = 0':' AND qty > 0';
        }else{
            $tstock = '';
        }
        return self::query(self::selectString().$where.$tproductname.$tstock.$tstatus.$tcategory_id.$tpackage_type.$tsub_category.$limit,$tab);
    }
}