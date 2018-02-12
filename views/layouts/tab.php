<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
 $controller = $this->context->id;
?>
<div class="row hidden-print">
    <div class="col-md-12"> 
      
      <?php
                    $menuItems = [
                        [
                            'label' => Yii::t('andahrm/edoc', 'Edoc'),
                            'url' => ["/{$module}/default"],
                            'icon' => 'fa fa-sitemap'
                        ],                      
                        [
                            'label' => Yii::t('andahrm/edoc', 'Edoc Insignia'),
                            'url' => ["/{$module}/insignia"],
                            'icon' => 'fa fa-id-badge',
                            'active'=>($controller=="insignia")?"active":""
                        ],
                        
                       
                        
                    ];
                    $menuItems = Helper::filter($menuItems);
                    
                    //$nav = new Navigate();
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-tabs bar_tabs'],
                        'encodeLabels' => false,
                        //'activateParents' => true,
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $menuItems,
                    ]);
                    ?>
      
      
     
      
    </div>
</div>

                <?php echo $content; ?>
         

<?php $this->endContent(); ?>
