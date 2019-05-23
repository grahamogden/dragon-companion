jQuery(document).ready(function($) {
    var map = '';
    var noOfCols = 0;
    var noOfRows = 0;
    // var radioButtons =
    //     '<label for="{{row}}{{col}}" class="puzzle-square" id="square" data-checked="0" data-max="4" data-for="{{row}}|{col}}"/>'+
    //     '<input type="radio" class="puzzle-radio square-none" id="none" name="{{row}}|{{col}}" value="0" checked="checked"/>'+
    //     '<input type="radio" class="puzzle-radio square-corridor" id="corridor" name="{{row}}|{{col}}" value="1" />'+
    //     '<input type="radio" class="puzzle-radio square-spawner" id="spawner" name="{{row}}|{{col}}" value="2" />'+
    //     '<input type="radio" class="puzzle-radio square-stairs" id="stairs" name="{{row}}|{{col}}" value="3" />'+
    //     '<input type="radio" class="puzzle-radio square-door" id="door" name="{{row}}|{{col}}" value="4" />';
    var radioButtonTemplate = '<input type="radio" class="puzzle-radio puzzle-{{id}}" id="{{id}}" name="{{row}}|{{col}}" value="{{value}}" {{checked}} />';
    var labelTemplate = '<label for="{{row}}|{{col}}" class="puzzle-label" data-for="{{row}}|{{col}}"></label>';
    var radioButtonValues = [
        'none',
        'corridor',
        'spawner',
        'stairs',
        'door',
        'start'
    ];
    var isViewing = false;

    var resetTable = function() {
        $('#puzzle-table tr').remove();

        noOfRows = 0;
        noOfCols = 0;
    }

    var getMapValue = function (x, y) {
        return 
    }

    var buildRadioButtons = function(rowCount, colCount) {
        let radioButtons = labelTemplate;
        for (var i = 0; i < radioButtonValues.length; i++) {
            let radio = radioButtonTemplate;
            radio = radio
            .replace(/{{id}}/g, radioButtonValues[i])
            .replace(/{{value}}/g, i);
            if (i === 0) {
                radio = radio.replace(/{{checked}}/g, 'checked="checked"');
            }
            radioButtons += radio;
        }
        radioButtons = radioButtons
            .replace(/{{row}}/g, rowCount)
            .replace(/{{col}}/g, colCount)
            .replace(/{{.*?}}/g, '');
        return radioButtons;
    }

    var addColumn = function() {
        // console.log('add column');
        ++noOfCols;
        let rowCount = 1;
        $('#puzzle-table tr').each(function(rowCount) {
            // console.log('----------');
            // console.log(rowCount);
            // console.log(noOfCols);
            // let radios = '';
            // for (var i = 0; i <= radioButtonValues.length; i++) {
            //     let radio = radioButtonTemplate;
            //     radios += radio
            //     .replace(/{{id}}/g, radioButtonValues[i])
            //     .replace(/{{row}}/g, rowCount)
            //     .replace(/{{col}}/g, noOfCols);
            // }
            radios = buildRadioButtons(rowCount, noOfCols);
            $(this).append('<td>' + radios + '</td>');
            rowCount++;
        }, rowCount);
    };

    var addRow = function() {
        // console.log('add row');
        ++noOfRows;
        $('#puzzle-table').append('<tr></tr>');
        for (let i = 0; i < noOfCols; i++) {
            // let radios = radioButtons
            //     .replace(/{{col}}/g, i)
            //     .replace(/{{row}}/g, noOfRows);
            radios = buildRadioButtons(noOfRows, i);
            $('#puzzle-table tr:last-child').append('<td>' + radios + '</td>');
        }
    };

    var reveal = function(x, y) {
        console.log('x:' + x +'; y: '+ y);
        if (y > 1) {
            revealUp(x, y);
        }

        if (y < noOfRows) {
            revealDown(x, y);
        }

        if (x > 1) {
            revealLeft(x, y);
        }

        if (x < noOfCols) {
            revealRight(x, y);
        }
    }

    var revealUp = function(x, y) {
        let $table = $('#puzzle-table');
        for(let i = y; i > 0; i--) {
            // $($table).find('tr:nth-of-type('+i+') td:nth-of-type('+x+') input[type=radio]:checked').val()
            // let position = 
            if (map[i]) {
                continue;
            }
        }
    }

    var revealDown = function(x, y) {
        
    }

    var revealLeft = function(x, y) {
        
    }

    var revealRight = function(x, y) {
        
    }

    var updateToCode = function() {
        map = '';

        map += noOfRows + '|' + noOfCols + '|';

        // for(let row = 0; row < noOfRows; ++row) {
            // for (let col = 0; col < noOfCols; ++col) {
        $('#puzzle-table tr').each(function() {
            $(this).find('td').each(function() {
                map += $(this).find('input[type=radio]:checked').val();
            });
        });

        $('#map').val(map);
    };

    var updateFromCode = function() {
        map = $('#map').val().split("|");
        // console.log(map);
        let rowLimit = parseInt(map[0]);
        let colLimit = parseInt(map[1]);
        map = map[2];
        // console.log(rowLimit);
        // console.log(colLimit);
        // console.log(map);
        // console.log(map.length);

        if ((rowLimit * colLimit) !== map.length) {
            console.log('Invalid');
            return;
        }

        resetTable();

        for(let row = 0; row < rowLimit; ++row) {
            addRow();
        }
        for (let col = 0; col < colLimit; ++col) {
            addColumn();
        // $('#puzzle-table tr').each(function() {
        //     $(this).find('td').each(function() {
        //         map += $(this).find('input[type=radio]:checked').val();
        //     });
        // });
        }

        if (isViewing) {
            // console.log(radioButtonValues.indexOf('start'));
            let key = map.indexOf(radioButtonValues.indexOf('start')) + 1;
            // console.log(map);
            // console.log('key: ' + key);
            // console.log('noOfCols: ' + noOfCols);
            // console.log('noOfRows: ' + noOfRows);

            if (key !== -1) {
                let row = Math.floor(key / noOfCols) + 1;
                let col = key - ((row - 1) * noOfCols);
                // console.log('row:' + row);
                // console.log('col:' + col);
                // console.log($('#puzzle-table tr:nth-of-type('+row+') td:nth-of-type('+col+')'));
                $('#puzzle-table tr:nth-of-type('+row+') td:nth-of-type('+col+') #start').click();
            }
        } else {
            let rowCount = 1;
            let colCount = 1;

            for (let key = 0; key < map.length; key++) {
                // console.log('Key:'+map[key]+';Row:'+rowCount+';Col:'+colCount);
                let $radios = $('#puzzle-table tr:nth-of-type('+rowCount+') td:nth-of-type('+colCount+') input[type=radio]');
                // :nth-of-type('+map[key]+')').click();
                $($radios).each(function() {
                    // console.log('Map value:'+map[key]);
                    if ($(this).val() == map[key]) {
                        $(this).click();
                    }
                });
                if (colCount >= colLimit) {
                    // console.log('reset col, increase row');
                    colCount = 0;
                    rowCount++;
                }
                colCount++;
            }
        }
    };

    var init = function() {
        if ($('#generate-from').length == 0) {
            isViewing = true; // Awful way to set this, but currently no other way!
        }

        updateFromCode();
    }

    $(document).on('click', '.puzzle-label', function(e) {
        e.preventDefault();
        // console.log('click!');
        let parent = $(this).parent('td');
        if (isViewing) {
            let coord = $(this).data('for').split('|');
            let x = coord[1];
            let y = coord[0];

            reveal(x, y);
        } else {
            // console.log(parent);
            let checkedRadio = $(parent).find('input[type=radio]:checked');
            // console.log(checkedRadio);
            let checkValue = parseInt($(checkedRadio).val());
            let maxValue = radioButtonValues.length - 1;
            // console.log(checkValue);
            // console.log(maxValue);

            let nextRadio = $(checkedRadio).next(':radio');
            if (checkValue === maxValue) {
                // console.log('Reset');
                nextRadio = $(parent).find('input[type=radio]:first');
            }
            // console.log(nextRadio);
            $(nextRadio).click();//attr('checked', 'checked');
            updateToCode();
        }
    });

    $('#add-column').click(function() {
        addColumn();
    });

    $('#add-row').click(function() {
        addRow();
    });

    $('#generate-code').click(function() {
        updateToCode();
    });

    $('#generate-from').click(function() {
        updateFromCode();
    });

    init();
});

// Example map code
// Number of Rows | Number of Columns | values of each tile
// 11|27|111111111111100000000000002000010000000100000000000000000020000000100000000000000000000111110100000001101100000000111110100000014414410000000113114100000014444410000000111110000000001444100000000111110000000000141000000000000000000000000010000000000000000000000000000000000000000000000000003000004