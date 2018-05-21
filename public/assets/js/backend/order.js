define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index',
                    show_url: 'order/show',
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    table: 'order',
                },
                // 单元格元素事件
                events: {
                    operate: {
                        'click .btn-showone': function (e, value, row, index) {
                            e.stopPropagation();
                            e.preventDefault();
                            var table = $(this).closest('table');
                            var options = table.bootstrapTable('getOptions');
                            var ids = row[options.pk];
                            row = $.extend({}, row ? row : {}, {ids: ids});
                            var url = options.extend.show_url;
                            Fast.api.open(Table.api.replaceurl(url, row, table), __('Detail'), $(this).data() || {});
                        },
                                            }
                },
            });

            var table = $("#table");

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
                        {field: 'flower_id', title: __('Flower_id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'amount', title: __('Amount')},
                        {field: 'subtotal', title: __('Subtotal')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'paid_time', title: __('Paid_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'if_paid', title: __('If_paid'), visible:false, searchList: {"0":__('If_paid 0'),"1":__('If_paid 1')}},
                        {field: 'if_paid_text', title: __('If_paid'), operate:false},
                        {field: 'flower.id', title: __('Flower.id')},
                        {field: 'flower.name', title: __('Flower.name')},
                        {field: 'flower.cate_id', title: __('Flower.cate_id')},
                        {field: 'flower.avatar', title: __('Flower.avatar')},
                        {field: 'flower.introduction', title: __('Flower.introduction')},
                        {field: 'flower.createtime', title: __('Flower.createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'flower.updatetime', title: __('Flower.updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'user.id', title: __('User.id')},
                        {field: 'user.group_id', title: __('User.group_id')},
                        {field: 'user.username', title: __('User.username')},
                        {field: 'user.nickname', title: __('User.nickname')},
                        {field: 'user.email', title: __('User.email')},
                        {field: 'user.mobile', title: __('User.mobile')},
                        {field: 'user.avatar', title: __('User.avatar')},
                        {field: 'user.gender', title: __('User.gender')},
                        {field: 'user.birthday', title: __('User.birthday'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'user.createtime', title: __('User.createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'user.updatetime', title: __('User.updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'user.status', title: __('User.status'), formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        show:function () {
            Controller.api.bindevent();
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});