<script type="text/javascript" defer>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Introduction to computers. Introduction to basic word processing and spreadsheet programs. Internet and information access. HTML Basic graphics.',
            height: 100
        });
        $('.note-editable').css({"height": "250", "background-color": "white"});
        $('.panel-heading').addClass("bg-light border-bottom border-secondary");
        $('.note-recent-color').css({"padding-left": "4px", "padding-right": "4px", "padding-bottom": "2px"})
    });

    var instructors = 1;

    function addInstructor() {
        instructors++;
        var $row = $("<div>", {"class": "row mb-5", "id": "inst-" + instructors});
        var $delCol = $("<div>", {"class": "col-md-1 d-flex align-items-end pb-1 justify-content-center i-del"});
        $delCol.append('<i class="fa fas fa-user-minus fa-2x" id="del-' + instructors + '"></i>');
        $delCol.on('click', function (instructors) { $('#inst-' + instructors.target.id.split('del-')[1]).remove(); });
        $row.append($('<div class="col-md"><div class="row mb-3"><div class="col-md"><label for="i_n_' + instructors + '">Instructor Name</label><input type="text" name="i_n_' + instructors + '" id="i_n_' + instructors + '" class="form-control" placeholder="Instructor Name"></div><div class="col-md"><label for="i_d_' + instructors + '">Instructor Designation</label><input type="text" name="i_d_' + instructors + '" id="i_d_' + instructors + '" class="form-control" placeholder="Instructor Designation"></div><div class="col-md"><label for="i_s_' + instructors + '">Instructor School/Department</label><input type="text" name="i_s_' + instructors + '" id="i_s_' + instructors + '" class="form-control" placeholder="Instructor Department"></div></div><div class="row"><div class="col-md"><label for="i_u_' + instructors + '">Instructor Image URL</label><input type="text" name="i_u_' + instructors + '" id="i_u_' + instructors + '" class="form-control"><span style="font-size: 70%;">This is the URL that you can copy from studio after uploading the image on studio</span></div></div></div>'));
        $row.append($delCol)
        $('#inst-cont').append($row);
    }

    function generateCode() {
        var htmlString = generateTags() + '<section class="about"><h2>About ' + $("#c_name").val() + '</h2><p style="text-align:justify;">' + $('#summernote').summernote('code') + '</p></section>';
        htmlString += '<section class="course-staff"><h2>Course Instructors</h2>' + generateInstructors() + '</section>';
        var text = formatFactory(htmlString);
        $("#output").val(text);
    }


    function generateTags(value) {
        var c_name = $("#c_name").val();
        var c_code = $('#c_code').val();
        var c_dept = $('#c_dept').val();
        var htmlString = '<p style="display:none"> ' + c_code + ' </p>';
        htmlString += '<p style="display:none"> ' + c_code.split(' ')[0] + ' </p>';
        htmlString += '<p style="display:none"> ' + c_code.split(' ')[1] + ' </p>';
        htmlString += '<p style="display:none"> ' + c_code.split(' ')[0] + c_code.split(' ')[1] + ' </p>';
        
        c_dept.split(',').forEach(value => {
            htmlString += '<p style="display:none"> ' + value + ' </p>';
        });

        htmlString += '<p style="display:none"> ' + c_name + ' </p>';

        return htmlString;
    }

    function generateInstructors() {
        var facString = '';

        for (let index = 1; index <= instructors; index++) {
            if (document.getElementById('i_n_' + index) != null) {
                facString += '<article class="teacher"><div class="teacher-image"><img src="' + document.getElementById('i_u_' + index).value + '" align="left" style="margin:0 20 px 0" alt="' + document.getElementById('i_n_' + index).value + '"></div><h3>' + document.getElementById('i_n_' + index).value + '</h3><p>' + document.getElementById('i_d_' + index).value + '<br/>' + document.getElementById('i_s_' + index).value + '</p></article>';
            }
        }

        return facString;
    }

    function formatFactory(html) {
        function parse(html, tab = 0) {
            var tab;
            var html = $.parseHTML(html);
            var formatHtml = new String();   

            function setTabs () {
                var tabs = new String();

                for (i=0; i < tab; i++){
                    tabs += '\t';
                }
                return tabs;    
            };


            $.each( html, function( i, el ) {
                if (el.nodeName == '#text') {
                    if (($(el).text().trim()).length) {
                        formatHtml += setTabs() + $(el).text().trim() + '\n';
                    }    
                } else {
                    var innerHTML = $(el).html().trim();
                    $(el).html(innerHTML.replace('/\n', '').replace(/ +(?= )/g, ''));
                    

                    if ($(el).children().length) {
                        $(el).html('\n' + parse(innerHTML, (tab + 1)) + setTabs());
                        var outerHTML = $(el).prop('outerHTML').trim();
                        formatHtml += setTabs() + outerHTML + '\n'; 

                    } else {
                        var outerHTML = $(el).prop('outerHTML').trim();
                        formatHtml += setTabs() + outerHTML + '\n';
                    }      
                }
            });

            return formatHtml;
        };   
        
        return parse(html.replace(/(\r\n|\n|\r)/gm," ").replace(/ +(?= )/g,''));
    };

    function copyCode() {
        $("#output").select();
        document.execCommand('copy');
    }
</script>