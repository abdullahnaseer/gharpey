@if(isset($service_seller))
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#questionsModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var service_seller_id = button.data('id') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('#service_seller_id').val(service_seller_id)
                console.log('service_seller_id: ' + service_seller_id)
            })

            $(".datepicker").datepicker({minDate: "+1D", maxDate: "+2M", defaultDate: new Date()});
            $(".datepicker").datepicker("setDate", "+1d");

            // var city = $('#city_id');
            // var city_input = $('#city_id_input');
            //
            // city.val(parseInt(city_input.val()));
            // city_input.on('change', function () {
            //     city.val(parseInt(city_input.val()));
            // });

            var questions = {!! json_encode($question_ids) !!};
            var currentQuestionIndex = 0;
            var countQuestions = {{ count($question_ids) }};

            $("#next").click(function () {
                // Check Validity
                var error = $('#error');
                var loading = $('#loading');
                var question = $("#service-question-" + questions[currentQuestionIndex]);
                var type = question.data("type");
                var required = question.data("required");

                if (type == '{!! str_replace( "\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeSelectMultiple::class ) !!}') {
                    var inpObj = $("input[name='answer-" + questions[currentQuestionIndex] + "[]']:checked");
                    if (required == 1) {
                        if (!inpObj.length) {
                            error.html("Please select one of these options.");
                            error.slideDown();
                            return false;
                        }
                    }
                } else if (type == '{!! str_replace( "\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeFileMultiple::class) !!}') {
                    var inpObj = document.getElementsByName("answer-" + questions[currentQuestionIndex] + "[]");
                    if (!inpObj[0].checkValidity()) {
                        error.html(inpObj[0].validationMessage);
                        error.slideDown();
                        return false;
                    }
                } else if (type == '{!! str_replace( "\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeTextMultiline::class) !!}') {
                    var inpObj = $("textarea[name='answer-" + questions[currentQuestionIndex] + "']");
                    if (!inpObj[0].checkValidity()) {
                        error.html(inpObj[0].validationMessage);
                        error.slideDown();
                        return false;
                    }
                } else {
                    var inpObj = $("input[name='answer-" + questions[currentQuestionIndex] + "']");
                    if (!inpObj[0].checkValidity()) {
                        error.html(inpObj[0].validationMessage);
                        error.slideDown();
                        return false;
                    }
                }
                error.slideUp();

                $("#service-question-" + questions[currentQuestionIndex]).slideUp(400, function () {
                    // Animation complete.
                    if (currentQuestionIndex >= countQuestions - 1) // Check if last question
                    {
                        loading.slideDown();
                        $('#back').hide();
                        $('#questionsForm').submit();
                        console.log('Last question');
                    } else {
                        currentQuestionIndex++;
                        if ($("#service-question-" + questions[currentQuestionIndex]).data("required") == 1)
                            $('#skip').hide();
                        else
                        {
                            if (currentQuestionIndex < countQuestions - 1) // Check if not last question
                                $('#skip').show();
                        }

                        $('#back').show();
                        $("#service-question-" + questions[currentQuestionIndex]).slideDown(400);
                    }
                });
            });


            $("#back").click(function () {
                if (currentQuestionIndex > 0) // Check if first question
                {
                    $("#service-question-" + questions[currentQuestionIndex]).slideUp(400, function () {
                        // Animation complete.
                        currentQuestionIndex--;
                        if (currentQuestionIndex <= 0) {
                            $('#back').hide();
                        }
                        if ($("#service-question-" + questions[currentQuestionIndex]).data("required") == 1)
                            $('#skip').hide();
                        else
                        {
                            if (currentQuestionIndex < countQuestions - 1) // Check if not last question
                                $('#skip').show();
                        }

                        $("#service-question-" + questions[currentQuestionIndex]).slideDown(400);
                    });
                }
            });

            $("#skip").click(function () {
                $("#service-question-" + questions[currentQuestionIndex]).slideUp(400, function () {
                    // Animation complete.
                    if (currentQuestionIndex >= countQuestions - 1) // Check if last question
                    {
                        loading.slideDown();
                        $('#back').hide();
                        $('#questionsForm').submit();
                        console.log('Last question');
                    } else {
                        currentQuestionIndex++;
                        if ($("#service-question-" + questions[currentQuestionIndex]).data("required") == 1)
                            $('#skip').hide();
                        else
                        {
                            if (currentQuestionIndex < countQuestions - 1) // Check if not last question
                                $('#skip').show();
                        }

                        $('#back').show();
                        $("#service-question-" + questions[currentQuestionIndex]).slideDown(400);
                    }
                });
            });

            $('.input-service-name').text($(".service-name").val());
        });


    </script>

    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
@endif
