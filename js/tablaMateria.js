/*
tablaAlumnos.js
Pinta la tabla de Alumnos con la opción de crear nuevos
*/
Ext.require([
    'Ext.plugin.Viewport'
]);
var nLinActual = -1;
Ext.onReady(function(){
	//Define "clase" Alumno
    Ext.define('Materia', {
		extend: 'Ext.data.Model',
		fields: ['clave', 'nombre', 'creditos']
	});
	
	//Define almacenamiento de Alumno proveniente de PHP y usado en la tabla (grid)
	Ext.create('Ext.data.Store', {
		extend: 'Ext.data.Store',
		storeId: 'Materias',
		model: 'Materia',
		autoLoad: true, //se carga al definirse
		autoSync: true,    //para ABC autónomo
		
		proxy: {
			type: 'ajax',
			actionMethods: {
				read: 'GET',
				update: 'POST'
			},
			batchActions: false,
			api: {
				read: 'buscaMaterias.php',
				update: 'buscaMaterias.php?txtOpe=m',
				destroy:'buscaMaterias.php?txtOpe=b'
			},
			reader: {
				type: 'json',
				rootProperty: 'arrMaterias'
			},
			writer: {
				type: 'json'
			},
			listeners: {
				exception: function(proxy, response, operation, eOpts) {
					Ext.Msg.alert(
						'Aviso',
						'Error al llamar al servidor :('
					);
				}
			}
		}
	});
	
	//Define tabla que usa almacenamiento proveniente de PHP
	Ext.create('Ext.grid.Panel', {
		renderTo: Ext.get("espacio1"),
		store: Ext.data.StoreManager.lookup('Materias'),
		width: "90%",
		height: "31em",
		title: 'Materias',
		selType: 'rowmodel',
		id: "tblMateria",
		plugins: {
			ptype: 'rowediting',
			clicksToEdit: 2,
			listeners: {
				edit: function(editor, e, eOpts) {
					 alert("Información enviada");
				}
			}
		},
		columns: [
			{
				text: 'Clave',
				width: '20%',
				dataIndex: 'clave'
			},
			{
				text: 'Nombre',
				width: '40%',
				dataIndex: 'nombre',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			},
			{
				text: 'Créditos',
				width: '40%',
				dataIndex: 'creditos',
				editor: {
					xtype: 'textfield',
					allowBlank: false
				}
			}
		],
		listeners: {
			select: function(selModel, record, index, options){
				nLinActual = index;
			}
		}
	});
});
