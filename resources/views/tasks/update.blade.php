if(typeof updateTaskCheck !== "function"){
    var skipUpdateTaskCheck = false;
    function updateTaskCheck(id, box, cardId) {
        if(skipUpdateTaskCheck){
            console.log("Skiped");
            return;
        }
        var is_finished = $( box ).is(':checked');
        $.post("/tasks/check",
        {
            "_token": "<?php echo e(csrf_token()); ?>",
            id: id,
            is_finished: is_finished
        },
        function(data, status){
            console.log("Uspeh");
            skipUpdateTaskCheck = true;
            var checkboxes = $('[data-checkbox-task-id="' + id + '"]');
            console.log(checkboxes);
            checkboxes.prop('checked', is_finished);
            for(var leav of allLeaves){
                var card = findCard(leav.id, cardId, allLeaves, null, null);
                if(card != null){
                    //console.log(card);
                    if(Array.isArray(card.tasks)){
                        var task = card.tasks.filter(function (o) { return o.id == id}).pop();
                        task.is_finished = is_finished;
                    }
                    break;
                }
            }
            skipUpdateTaskCheck = false;
        });
    }
}