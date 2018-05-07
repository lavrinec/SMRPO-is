<?php
/**
 * Created by PhpStorm.
 * User: matjazglumac
 * Date: 03/05/18
 * Time: 22:48
 */
?>
<script type="text/javascript">
    var helpAllSteps = 0,
        helpCurrentStep = 1,
        docSingleStepRation = 0,
        docStepSum = 0,
        helpCurrentIndex = 0,
        documentationContent = [];

    function showDocumentationModel(){
        $('#documentationModel').modal('show');
    }

    function resetDocumentationModel(){
        $('#documentationModel h4.modal-title').text("");
        $('#documentationModel .modal-body').text("");
        $('#documentationModel .modal-footer #next-step').remove();
        $('#documentationModel .modal-footer #previous-step').remove();
    }
    function stepClicked (e) {
        if(e.target.id != undefined && e.target.id != null && e.target.id == 'next-step'){
            helpCurrentStep = helpCurrentStep+1;
            helpCurrentIndex = helpCurrentStep-1;
            docStepSum = docStepSum + docSingleStepRation;
            resetDocumentationModel();
            setHtmlInModal();
        }else if(e.target.id != undefined && e.target.id != null && e.target.id == 'previous-step'){
            helpCurrentStep = helpCurrentStep-1;
            helpCurrentIndex = helpCurrentStep-1;
            docStepSum = docStepSum - docSingleStepRation;
            resetDocumentationModel();
            setHtmlInModal();
        }
    }
    function setHtmlInModal(){
        var progressBar = $('#documentationModel .modal-progress-bar-inner');
        progressBar.css('width',Math.round(docStepSum) +'%');
        //progressBar.text(Math.round(docStepSum)+"%");
        var nextButton = $('#documentationModel .modal-footer #next-step');
        var prevButton = $('#documentationModel .modal-footer #previous-step');
        if (helpCurrentStep>1 && (!prevButton.length || prevButton == undefined || prevButton == null) ){
            var stepbutton = document.createElement('button');
            stepbutton.addEventListener("click", stepClicked);
            stepbutton.id = 'previous-step';
            stepbutton.className = 'btn btn-default';
            stepbutton.innerHTML= 'Nazaj';
            $('#documentationModel div.modal-footer').append(stepbutton);
        }
        if( ( !nextButton.length || nextButton == undefined || nextButton == null) && helpCurrentStep != helpAllSteps){
            var stepbutton = document.createElement('button');
            stepbutton.addEventListener("click", stepClicked);
            stepbutton.id = 'next-step';
            stepbutton.className = 'btn btn-default';
            stepbutton.innerHTML= 'Naprej';
            $('#documentationModel div.modal-footer').append(stepbutton);
        }

        $('#documentationModel h4.modal-title').html("<h1 style='text-align:center;'>"+ documentationContent[helpCurrentIndex].title +"  " +helpCurrentStep+"/" + helpAllSteps+"</h1>");
        $('#documentationModel .modal-body').html(documentationContent[helpCurrentIndex].body);
    }

    function resetDocumentationSettings(){
        resetDocumentationModel();
        helpCurrentStep=1;
        helpCurrentIndex =0;
    }


    function openDocumentationModal(){
        helpAllSteps = documentationContent.length; //documentationContent[helpCurrentIndex].allSteps;
        docSingleStepRation = (1/helpAllSteps)*100;
        docStepSum= docSingleStepRation;
        resetDocumentationSettings();
        setHtmlInModal();
        showDocumentationModel();
    }
</script>
