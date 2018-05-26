define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index',
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    table: 'order',
                }
            });
            table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'order_id',
                sortName: 'order_id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'order_id', title: __('Order_id')},
                        {field: 'order_sn', title: __('Order_sn')},
                        {field: 'flower.name', title: __('Flower.name')},
                        {field: 'flower.avatar', title: __('Flower.avatar'),formatter: Table.api.formatter.image},
                        {field: 'user.username', title: __('Client_name')},
                        {field: 'user.mobile', title: __('User.mobile')},
                       {field: 'price', title: __('Price')+'(元)', operate:'BETWEEN'},
                        {field: 'amount', title: __('Amount')},
                        {field: 'subtotal', title: __('Subtotal')+'(元)'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'paid_time', title: __('Paid_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'if_paid_text', title: __('If_paid'), visible:true,formatter: Table.api.formatter.status,custom:{'已付款':'success',"未付款":'danger'}},
                        {field: 'if_paid', title: __('If_paid'), visible:false,formatter: Table.api.formatter.status,searchList: {"0":__('If_paid 0'),"1":__('If_paid' + ' 1')}},
                        {field: 'operate', title: __('Operate'), buttons: [
                            {name: 'detail', text: '', title: '详情', icon: 'fa fa-list', classname: 'btn btn-xs btn-primary btn-dialog', url: 'order/detail'}
                        ],table:table,events: Table.api.events.operate, formatter: Table.api.formatter.operate,}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            var checkText=$("input[type=radio]").val();
            if(checkText==0){
                $('#c-paid_time').attr('disabled','disabled');
            }else{
                $('#c-paid_time').attr('disabled',false);
                $('#paid_time-control').hide();
            }
            //添加单机事件
            $("input[type=radio]").click(function () {
                var checkText=$("input[type=radio]:checked").val();
                if(checkText==1){
                    $('#c-paid_time').attr('disabled',false);
                    $('#paid_time-control').show();
                }else{
                    $('#paid_time-control').hide();
                    $('#c-paid_time').attr('disabled','disabled');
                }
            });


            var priceObj=$('#c-price');
            var amountObj=$('#c-amount');
            var subtotalObj=$('#c-subtotal');
            priceObj.change(function () {
                if(amountObj.val()!==0){
                    var price=priceObj.val();
                    var amount=amountObj.val();
                    subtotalObj.val(price*amount);
                }
            });

            amountObj.change(function () {
                if(priceObj.val()!==0){
                    var price=priceObj.val();
                    var amount=amountObj.val();
                    subtotalObj.val(price*amount);
                }
            });

            Controller.api.bindevent();
        },
        edit: function () {
            var checkText=$("input[type=radio]:checked").val();
            console.log(checkText)
            if(checkText==0){
                $('#c-paid_time').attr('disabled','disabled');
            }else{
                $('#c-paid_time').attr('disabled',false);
                $('#paid_time-control').show();
            }
            //添加单机事件
            $("input[type=radio]").click(function () {
                var checkText=$("input[type=radio]:checked").val();
                if(checkText==1){
                    $('#c-paid_time').attr('disabled',false);
                    $('#paid_time-control').show();
                }else{
                    $('#paid_time-control').hide();
                    $('#c-paid_time').attr('disabled','disabled');
                }
            });


            var priceObj=$('#c-price');
            var amountObj=$('#c-amount');
            var subtotalObj=$('#c-subtotal');
            priceObj.change(function () {
                if(amountObj.val()!==0){
                    var price=priceObj.val();
                    var amount=amountObj.val();
                    subtotalObj.val(price*amount);
                }
            });

            amountObj.change(function () {
                if(priceObj.val()!==0){
                    var price=priceObj.val();
                    var amount=amountObj.val();
                    subtotalObj.val(price*amount);
                }
            });
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },

        }
    };
    return Controller;
});