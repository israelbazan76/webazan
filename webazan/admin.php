<?php
/* @var $this UsersController */
/* @var $model Users */




Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php 
if(Yii::app()->user->hasFlash('success')):
    echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success'));
      
endif;
?>
<h1>Usuarios</h1>



<?php //echo CHtml::link('Busqueda avanzada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php 
/*$this->renderPartial('_search',array(
	'model'=>$model,
)); */
?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_LIST,
    'items' => array(
        array('label' => 'Crear nuevo usuario', 'url' => array('create')),
    )
));
echo '<div style="float:left">';
     
    echo '<div style="float:left">';
    echo CHtml::dropDownList('action', null,array('notificar'=>'Enviar mail de activacion','activar'=>'Activar','desactivar'=>'Desactivar'),array('prompt'=>'Seleccione una accion' ));
 echo '</div>';
 
    echo '<div style="float:left">';
    
    echo CHtml::ajaxLink("procesar", $this->createUrl('site/getValue'), array(
        "type" => "post",
        "data" => 'js:{theIds : $.fn.yiiGridView.getChecked("users-grid","selectedIds").toString(),"action":$("#action").val()}',
        "success" => 'js:function(data){ $.fn.yiiGridView.update("users-grid")  }' ),array(
        'class' => 'btn btn-primary'
        )
        );
 echo '</div>';
 echo '</div>'; 
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
    'type'=>'striped bordered condensed',
	'filter'=>$model,
	'columns'=>array(
			array(
                'name' => 'check',
                'id' => 'selectedIds',
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '100',
 
            ),
		array(
		    'name' => 'id',
		    'htmlOptions'=>array('width'=>'20'),
            'headerHtmlOptions'=>array('width'=>'20') 
		),
		'username',
		
		'name',
		'lastname',
		'email',
		 array(
		   'name' => 'is_active',
           'type' => 'raw',
           'value' => '$data->is_active>0?TbHtml::labelTb("activado", array("color" => TbHtml::LABEL_COLOR_SUCCESS)):TbHtml::labelTb("sin activar", array("color" => TbHtml::LABEL_COLOR_IMPORTANT))',
      	   'filter' => false
           ),
        array(
		    'name' => 'roles',
		    'htmlOptions'=>array('width'=>'100'),
            'headerHtmlOptions'=>array('width'=>'100') 
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		    'template'=>'{update}{delete}',
             			  'buttons'=>array(       
                                'delete' => array( //the name {reply} must be same
                					 'label' => 'Eliminar', // text label of the button
                  			    ),
                  			    
                  			     'update' => array( //the name {reply} must be same
                					 'label' => 'Modificar', // text label of the button
                  			    ),
                                
                        ),
		),
	),
)); ?>