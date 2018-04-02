<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/dependencies/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/dependencies/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="/dependencies/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="/dependencies/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/dependencies/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="/dependencies/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="/dependencies/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/demo.js"></script>
<!-- DataTables -->
<script src="/dependencies/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/dependencies/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
    $(function () {
        $('#example1').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "language": {
                "url": "/dependencies/datatables.net/js/slovenian.json"
            }
        });

        $('#usersgroupsselect').select2({
            placeholder: 'Select an option',
            multiple:"multiple",
            theme:"classic",
            allowClear:true,
            tags:true
        });


        $('.openCard').on('click',function(e){
            var target = $(e.target), cardId = target.data('cardId'), boardId = target.data('boardId');
            $('#cardModal .modal-body').load('/cards/' + cardId + '/edit/' + boardId,function(){
                $('#cardModal').modal({show:true});
            });
        });

        $('#saveCard').on('click',function(e){
            var target = $(e.target), $form = $('#updateCard');
            target.hide();
            $('#cardModal .modal-body').html("");
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(result) {
                    alert("Opravljeno");
                }
            });
            $('#cardModal').modal({show:false});
            target.show();
        });
    });

    $(document).ready(function(){
        //js-example-basic-single

    });
</script>