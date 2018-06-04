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

    function openCard(cardId, boardId, collumnId) {
        var param = boardId ? ( '/' + boardId + (collumnId ? ( '/' + collumnId ) : '')) : '';
        console.log(cardId, boardId, collumnId, param);
        $('#cardModal .modal-content').load('/cards/' + cardId + '/edit' + param ,function(){
            $('#cardModal').modal({show:true});
            $('#updateCard').on('submit',function(e){
                e.preventDefault();
                var $form = $('#updateCard');
                $('#cardModal .modal-content').html("");
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function (result) {
                        $('#cardModal').modal('hide');
                        $('#saveCard').show();
                        if(cardId == 0){
                            //saving
                            var id = '#tbody_td_' + result.project_id + '_' + result.column_id;
                            var elem = $( id );
                            console.log(result, elem, id);
                            elem.append(result.view);
                        } else {
                            $( document ).find("[data-card-id='" + result.id + "']").replaceWith(result.view);
                        }
                    }
                });
            });
        });
    }

    function findQuoteCriticalFromLocalStorage(boardId){
        console.log('jep');

        // var cardColumnIndex = window.allColumns.findIndex(function(element,i){
        //     //if(element.)
        //     console.log(element);
        // });
        var deadlineFromLocalStorage = localStorage.getItem('criticalDayDeadlineSessionData'+'-'+boardId);
        if(deadlineFromLocalStorage != null && deadlineFromLocalStorage != undefined){
            var theDeadline = new Date(deadlineFromLocalStorage);

            for(var i = 0 ; i < window.myAllCards.length ; i++){
                var cardIterated = window.myAllCards[i];

                console.log('here problem');
                if((cardIterated.deadline != null) && (cardIterated.deadline != undefined)){
                    var cardDeadline = new Date(cardIterated.deadline);
                    if(cardDeadline.getTime() <= theDeadline.getTime()) {
                        var beyondTesting = checkIfCardBeyondTesting(cardIterated);
                        console.log('kaj se dogaja' + beyondTesting);

                        if(beyondTesting==true){
                            colorCard(cardIterated.id, 'rgb(230,140,100');
                            continue;
                        }

                    }
                }
                colorCard(cardIterated.id, cardIterated.color);
            }
        }

    }
    function colorCard(cardId, newColor){
        var foundCardDiv = $('*[data-card-id="'+cardId+'"]');
        var foundChildCardDiv = $('*[data-card-id="' + cardId + '"] .box-header');
        if(foundCardDiv != null && foundCardDiv != undefined && foundChildCardDiv != null && foundChildCardDiv != undefined){
            console.log('jup');
            foundCardDiv.css('border-color', newColor);
            // foundCardDiv.css('border-color', 'rgb(230,140,100)');
            foundChildCardDiv.css('background-color', newColor);
            // foundChildCardDiv.css('background-color', 'rgb(230,140,100)');
        }
    }
    function checkIfCardBeyondTesting(cardToTest){
        var acceptanceTestingColumnIndex = window.allColumns.findIndex(function (element, i) {
            if (element.acceptance_testing == true) {
                return true;
            }
        });
        var cardColumnIndex = window.allColumns.findIndex(function(element,i){
            if(element.id == cardToTest.column_id){
                return i;
            }
        });
        console.log('test index: ' + acceptanceTestingColumnIndex + ' curent column ' + cardColumnIndex);
        if(cardColumnIndex < acceptanceTestingColumnIndex){
            return true;
        }
        return false;

    }

    function handleCardUpdate(updatedCard, boardId){
        console.log('what is deeadline : ' + updatedCard.deadline);
        var cardDeadline = $('#updateCard #deadline').val();
        updatedCard.deadline = cardDeadline;
        console.log('what is deeadline : ' + updatedCard.deadline);
        window.myAllCards = findCardAndReplaceContent(updatedCard);
        setTimeout(function(){findQuoteCriticalFromLocalStorage(boardId);},350);
    }

    function findCardAndReplaceContent(updatedCard){
        var allCards = window.myAllCards;
        if(allCards != null && allCards!=undefined){
            var swapIndex = allCards.findIndex(function(element,i){
                if(element.id == updatedCard.id){
                    return i;
                }
            });
            if(swapIndex != null && swapIndex != undefined && swapIndex != -1){
                allCards[swapIndex] = updatedCard;
            }
        }
        return allCards;
    }

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
            var target = $(e.target), cardId = target.data('cardId'), boardId = target.data('boardId'), collumnId = target.data('collumnId');
            openCard(cardId,boardId,collumnId);
        });
/*
        $('#saveCard').on('click',function(e) {
            $('#saveCard').hide();
            $('#updateCard').submit();
        });
        */
    });

    $(document).ready(function(){
        //js-example-basic-single

    });
</script>