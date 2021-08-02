<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/app.js"></script>

</head>
<body>
<div class="container-fluid">
    <div class="btn-toolbar m-2" role="toolbar" aria-label="Toolbar with button groups"></div>
    <div class="btn-group" role="group" aria-label="First group">
        <button type="button" class="btn-lg mr-2 btn-secondary" id="text">Text</button>
        <button type="button" class="btn-lg mr-2 btn-secondary" id="brush">Brush</button>
        <button type="button" class="btn-lg mr-2 btn-secondary" id="todo">Todo</button>
        <button type="button" class="btn-lg mr-2 btn-secondary" id="delete">Delete</button>
    </div>
    <div class="canvas"></div>
    <canvas class="canvas m-1 " id="canvas" width="800" height="600" style="border:2px solid #000000">
    </canvas>

</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let canvas = new fabric.fabric.Canvas('canvas', {
        isDrawingMode: false
    });
    canvas.setWidth(900);
    canvas.setHeight(600);
    let isDelete = false;
    let brushElem = document.getElementById('brush');
    let deleteElem = document.getElementById('delete');


    $(document).on('click', '#todo', function () {
        const todo = new fabric.fabric.Textbox('MyText', {
            width: 200,
            fill: 'black',
            charSpacing: 30,
            scaleY: 5,
            top: 10,
            left: 10,
            fontSize: 20,
            textAlign: 'center',
            backgroundColor: 'yellow',
            fixedWidth: 150
        });

        canvas.on('text:changed', function (opt) {
            const todo = opt.target;
            if (todo.width > todo.fixedWidth) {
                todo.fontSize *= todo.fixedWidth / (todo.width + 1);
                todo.width = todo.fixedWidth;
            }
        });
        canvas.add(todo);
    });

    $(document).on('click', '#brush', function () {
            canvas.isDrawingMode = !canvas.isDrawingMode;
            if (canvas.isDrawingMode) {
                brushElem.innerHTML = 'Cancel';
                console.log(JSON.stringify(canvas));
            } else {
                brushElem.innerHTML = 'Brush';
            }
        }
    );

    $(document).on('click', '#text', function () {
        canvas.add(new fabric.fabric.IText('Tap and Type', {
            fontFamily: 'arial black',
            left: 100,
            top: 100,
        }));
        console.log(JSON.stringify(canvas));
    });

    $(document).on('click', '#delete', function (e) {
        isDelete = !isDelete;
        if (isDelete) {
            deleteElem.innerHTML = 'Cancel';
        } else {
            console.log(isDelete)
            deleteElem.innerHTML = 'Delete';
        }
    });

    function SaveCanvas() {
        const dataJson = JSON.stringify(canvas);
        $.post('save', {data: dataJson}, function (response) {
            console.log(response)
        })
    }


</script>
</body>
</html>
