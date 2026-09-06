$(document).ready(function () {

    $("#send_message").click(function (e) {

        e.preventDefault();

        let error = false;

        let name = $("input[name='name']").val().trim();
        let email = $("input[name='email']").val().trim();
        let phone = $("input[name='phone']").val().trim();
        let project = $("textarea[name='project_description']").val().trim();
        let type = $("select[name='project_type']").val();
        let budget = $("select[name='budget']").val();
        let timeline = $("select[name='timeline']").val();

        $(".form-control").removeClass("error_input");

        if (name === "") {
            $("input[name='name']").addClass("error_input");
            error = true;
        }

        if (email === "" || email.indexOf("@") === -1) {
            $("input[name='email']").addClass("error_input");
            error = true;
        }

        if (phone === "") {
            $("input[name='phone']").addClass("error_input");
            error = true;
        }

        if (project === "") {
            $("textarea[name='project_description']").addClass("error_input");
            error = true;
        }

        if (type === "") {
            $("select[name='project_type']").addClass("error_input");
            error = true;
        }

        if (budget === "") {
            $("select[name='budget']").addClass("error_input");
            error = true;
        }

        if (timeline === "") {
            $("select[name='timeline']").addClass("error_input");
            error = true;
        }

        if (!error) {

            $("#send_message")
                .prop("disabled", true)
                .val("Sending...");

            $.ajax({
                url: "get-a-quote.php",
                type: "POST",
                data: $("#estimator-form").serialize(),

                success: function (result) {

                    if ($.trim(result) === "sent") {

                        var html = "";

                        html += '<table class="table table-bordered table-striped">';
                        html += "<tbody>";

                        html += "<tr><th width='250'>Name</th><td>" + $("input[name='name']").val() + "</td></tr>";
                        html += "<tr><th>Email</th><td>" + $("input[name='email']").val() + "</td></tr>";
                        html += "<tr><th>Phone</th><td>" + $("input[name='phone']").val() + "</td></tr>";
                        html += "<tr><th>Company</th><td>" + $("input[name='company']").val() + "</td></tr>";
                        html += "<tr><th>Project Description</th><td>" + $("textarea[name='project_description']").val().replace(/\n/g, "<br>") + "</td></tr>";
                        html += "<tr><th>Project Type</th><td>" + $("select[name='project_type']").val() + "</td></tr>";
                        html += "<tr><th>Property Size</th><td>" + $("select[name='property_size']").val() + "</td></tr>";
                        html += "<tr><th>Estimated Budget</th><td>" + $("select[name='budget']").val() + "</td></tr>";
                        html += "<tr><th>Project Timeline</th><td>" + $("select[name='timeline']").val() + "</td></tr>";
                        html += "<tr><th>Preferred Style</th><td>" + $("select[name='style']").val() + "</td></tr>";
                        html += "<tr><th>Preferred Start Date</th><td>" + $("input[name='start_date']").val() + "</td></tr>";
                        html += "<tr><th>Project Address</th><td>" + $("input[name='address']").val() + "</td></tr>";
                        html += "<tr><th>Special Requirements</th><td>" + $("textarea[name='requirements']").val().replace(/\n/g, "<br>") + "</td></tr>";

                        html += "</tbody>";
                        html += "</table>";

                        $("#quote_summary").html(html);

                        // Hide form after successful submission
                        $("#form-wrapper").hide();

                        // Show success message
                        $("#quote_success")
                            .removeClass("d-none")
                            .hide()
                            .fadeIn(500);

                    } else {

                        alert("Failed to send your request. Please try again.");

                        $("#send_message")
                            .prop("disabled", false)
                            .val("Get Free Estimate");
                    }

                },

                error: function () {

                    alert("Unable to connect to the server.");

                    $("#send_message")
                        .prop("disabled", false)
                        .val("Get Free Estimate");
                }

            });

        }

    });

});