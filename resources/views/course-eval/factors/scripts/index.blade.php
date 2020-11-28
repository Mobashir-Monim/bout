<script>
    let fCont = document.getElementById('factors-cont');
    let factors = JSON.parse('{!! $helper->eval->factors !!}');
    let count = 0;

    const removeFactor = id => {
        let target = document.getElementById(id);
        target.parentElement.removeChild(target);
        delete factors[id];
    }

    const addFactor = () => {
        fCont.innerHTML += `
            <div class="card my-3" id="fAdd${ count }">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1 offset-md-11 text-right">
                            <a href="#/" onclick="removeFactor('fAdd${ count }')" class="btn btn-light"><span aria-hidden="true">&times;</span></a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-8 my-auto">Name:<input type="text" name="name[]" class="form-control" placeholder="Name of factor"></div>
                        <div class="col-md-4 my-auto">Short Hand:<input type="text" name="short_hand[]" class="form-control" placeholder="Short Hand of factor"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            Description:
                            <textarea name="description[]" class="form-control" placeholder="Description of factor"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;

        count++;
    }
</script>