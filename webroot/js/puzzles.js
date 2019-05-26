jQuery(document).ready(function($) {
    var map = [];
    var noOfCols = 0;
    var noOfRows = 0;
    // var radioButtons =
    //     '<label for="{{row}}{{col}}" class="puzzle-square" id="square" data-checked="0" data-max="4" data-for="{{row}}|{col}}"/>'+
    //     '<input type="radio" class="puzzle-radio square-none" id="none" name="{{row}}|{{col}}" value="0" checked="checked"/>'+
    //     '<input type="radio" class="puzzle-radio square-corridor" id="corridor" name="{{row}}|{{col}}" value="1" />'+
    //     '<input type="radio" class="puzzle-radio square-spawner" id="spawner" name="{{row}}|{{col}}" value="2" />'+
    //     '<input type="radio" class="puzzle-radio square-stairs" id="stairs" name="{{row}}|{{col}}" value="3" />'+
    //     '<input type="radio" class="puzzle-radio square-door" id="door" name="{{row}}|{{col}}" value="4" />';
    var radioButtonTemplate = '<input type="radio" class="puzzle-radio puzzle-{{id}}" id="{{id}}" name="{{row}}|{{col}}" value="{{value}}" />';
    var tileHtmlTemplate = '';
    var labelTemplate = '<label for="{{row}}|{{col}}" class="puzzle-label" data-for="{{row}}|{{col}}"></label>';
    var tileOptions = [
        {
            name: 'none',
            value: 0,
            empty: false
        },{
            name: 'corridor',
            value: 1,
            empty: true
        },{
            name: 'stairs',
            value: 2,
            empty: true
        },{
            name: 'door',
            value: 3,
            empty: false
        },{
            name: 'hidden',
            value: 4,
            empty: false
        },{
            name: 'spawner',
            value: 5,
            empty: true
        },{
            name: 'start',
            value: 6,
            empty: true
        }
    ];
    var isViewing = false;

    var getTileOptionByName = function (name) {
        return tileOptions.find(x => x.name === name);//tileOptions.indexOf(name);
    }

    var getTileOptionByValue = function (value) {
        return tileOptions.find(x => x.value === parseInt(value));//tileOptions.indexOf(name);
    }

    var activateTile = function (x, y, value) {
        // console.log('You clicked - X:'+x+'; Y:'+y+'; Value:'+value+'; Target - X:'+(x+1)+'; Y:'+(y+1)+';');
        ++x;
        ++y;
        // console.log($('#puzzle-table tr:nth-of-type('+y+') td:nth-of-type('+x+') input[type=radio][value='+value+']'));
        $('#puzzle-table tr:nth-of-type('+y+') td:nth-of-type('+x+') input[type=radio][value='+value+']').click();
    }

    var activateAllTiles = function () {
        // console.log('You clicked - X:'+x+'; Y:'+y+'; Value:'+value+'; Target - X:'+(x+1)+'; Y:'+(y+1)+';');
        // ++x;
        // ++y;
        // console.log($('#puzzle-table tr:nth-of-type('+y+') td:nth-of-type('+x+') input[type=radio][value='+value+']'));
        let $puzzleTable = $('#puzzle-table');
        for (let y = 0; y < noOfRows; ++y) {
            let $row = $($puzzleTable).find('tr:nth-of-type('+(y+1)+')');
            for (let x = 0; x < noOfCols; ++x) {
                let value = null;
                if (map !== undefined && map[y] !== undefined) {
                    if (map[y].length > 1) {
                        value = map[y][x];
                    } else {
                        value = map[y];
                    }
                }
                $($row).find('td:nth-of-type('+(x+1)+') input[type=radio][value="'+value+'"]').click();
                // activateTile(x, y, value);
            }
        }
    }

    var resetTable = function() {
        $('#puzzle-table tr').remove();

        noOfRows = 0;
        noOfCols = 0;
    }

    var resetTiles = function() {
        $('#puzzle-table tr td input[type=radio][value="0"]').click();
    }

    var generateTile = function(rowCount, colCount) {
        let tileHtml = tileHtmlTemplate;
        // // for (var i = 0; i < tileOptions.length; i++) {
        // $(tileOptions).each(function() {
        //     let radio = radioButtonTemplate;
        //     radio = radio
        //     .replace(/{{id}}/g, this.name)
        //     .replace(/{{value}}/g, this.value);
        //     if (this.value === 0) {
        //         radio = radio.replace(/{{checked}}/g, 'checked="checked"');
        //     }
        //     radioButtons += radio;
        // });
        // console.log(tileHtml);
        return tileHtml
            .replace(/{{row}}/g, rowCount)
            .replace(/{{col}}/g, colCount)
            .replace(/{{.*?}}/g, '');
        // console.log(return2);
        // return return2;
    }

    var generateTiles = function () {
        tileHtmlTemplate += labelTemplate;
        $(tileOptions).each(function() {
            let radio = radioButtonTemplate;
            tileHtmlTemplate += radio
                .replace(/{{id}}/g, this.name)
                .replace(/{{value}}/g, this.value);
        });
        // console.log(tileHtmlTemplate);
    }

    var addColumn = function() {
        // console.log('add column');
        let rowCount = 0;
        $('#puzzle-table tr').each(function() {
            // console.log('----------');
            // console.log(rowCount);
            // console.log(noOfCols);
            // let radios = '';
            // for (var i = 0; i <= tileOptions.length; i++) {
            //     let radio = radioButtonTemplate;
            //     radios += radio
            //     .replace(/{{id}}/g, tileOptions[i])
            //     .replace(/{{row}}/g, rowCount)
            //     .replace(/{{col}}/g, noOfCols);
            // }
            radios = generateTile(rowCount, noOfCols);
            $(this).append('<td>' + radios + '</td>');
            rowCount++;
        });
        ++noOfCols;
    };

    var addRow = function() {
        // console.log('add row');
        // console.log(noOfRows);
        $('#puzzle-table').append('<tr></tr>');
        for (let i = 0; i < noOfCols; i++) {
            // let radios = radioButtons
            //     .replace(/{{col}}/g, i)
            //     .replace(/{{row}}/g, noOfRows);
            radios = generateTile(noOfRows, i);
            $('#puzzle-table tr:last-child').append('<td>' + radios + '</td>');
        }
        ++noOfRows;
    };

    var reveal = function(x, y) {
        // console.time('Reveal');
        // console.log('x:' + x +'; y: '+ y);
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
        // console.timeEnd('Reveal');
    }

    var revealUp = function(x, y) {
        // console.log('revealUp');
        let $table = $('#puzzle-table');
        // let tileOption = getTileOptionByName('corridor');
        for (let i = y; i >= 0; --i) {
            let value = null;
            if (map !== undefined && map[i] !== undefined && map[i].length > 1) {
                value = map[i][x];
            } else {
                value = map[i];
            }
            // $($table).find('tr:nth-of-type('+i+') td:nth-of-type('+x+') input[type=radio]:checked').val()
            let tileOption = getTileOptionByValue(value);
            // console.log(tileOption);
            // if (map[i][x] == tileOption.value) {
            if (tileOption.empty) {
                activateTile(x, i, tileOption.value);
            } else if (i != y) {
                activateTile(x, i, tileOption.value);
                break;
            }
        }
    }

    var revealDown = function(x, y) {
        // console.log('revealDown');
        let $table = $('#puzzle-table');
        // console.log('X:'+x+';Y:'+y+';noOfRows:'+noOfRows+';');
        for (let i = y; i < noOfRows; ++i) {
            // console.log(i);
            let value = null;
            if (map !== undefined && map[i] !== undefined && map[i].length > 1) {
                value = map[i][x];
            } else {
                value = map[i];
            }
            let tileOption = getTileOptionByValue(value);
            // console.log(tileOption);
            if (tileOption.empty) {
                activateTile(x, i, tileOption.value);
            } else if (i != y) {
                activateTile(x, i, tileOption.value);
                break;
            }
        }
    }

    var revealLeft = function(x, y) {
        // console.log('revealLeft');
        let $table = $('#puzzle-table');
        // let tileOption = getTileOptionByName('corridor');
        for (let i = x; i >= 0; --i) {
            let value = null;
            if (map !== undefined && map[y] !== undefined && map[y].length > 1) {
                value = map[y][i];
            } else {
                value = map[y];
            }
            // console.log(value);
            // $($table).find('tr:nth-of-type('+i+') td:nth-of-type('+x+') input[type=radio]:checked').val()
            let tileOption = getTileOptionByValue(value);
            // console.log(tileOption);
            // if (map[i][x] == tileOption.value) {
            if (tileOption.empty) {
                activateTile(i, y, tileOption.value);
            } else if (i != x) {
                activateTile(i, y, tileOption.value);
                break;
            }
        }
    }

    var revealRight = function(x, y) {
        // console.log('revealRight');
        let $table = $('#puzzle-table');
        for (let i = x; i < noOfCols; ++i) {
            let value = null;
            if (map !== undefined && map[y] !== undefined && map[y].length > 1) {
                value = map[y][i];
            } else {
                value = map[y];
            }
            let tileOption = getTileOptionByValue(value);
            if (tileOption.empty) {
                activateTile(i, y, tileOption.value);
            } else if (i != x) {
                activateTile(i, y, tileOption.value);
                break;
            }
        }
    }

    var updateToCode = function() {
        // map = noOfRows + '|' + noOfCols + '|';

        // for(let row = 0; row < noOfRows; ++row) {
            // for (let col = 0; col < noOfCols; ++col) {
        map = [];
        var rowCounter = 0;
        var colCounter = 0;
        $('#puzzle-table tr').each(function() {
            $(this).find('td').each(function() {
                if (map[rowCounter] === undefined) {
                    map[rowCounter] = '';
                }
                // console.log('-------------');
                // console.log(rowCounter);
                // console.log(colCounter);
                map[rowCounter] += $(this).find('input[type=radio]:checked').val() ? $(this).find('input[type=radio]:checked').val() : 0;
                ++colCounter;
            });
            colCounter = 0;
            ++rowCounter;
        });

        $('#map').val(noOfRows + '|' + noOfCols + '|' + map.join(''));
    };

    var updateFromCode = function() {
        let mapString = $('#map').val().split("|");
        // console.log(mapString);
        
        // Set the row and col limit from the stored string
        let rowLimit = parseInt(mapString[0] ?mapString[0]: 0);
        let colLimit = parseInt(mapString[1] ?mapString[1]: 0);
        mapString = mapString[2] ?mapString[2]: '';
        // console.log(rowLimit);
        // console.log(colLimit);
        // console.log(mapString);
        // console.log(mapString.length);

        // Check that we have the right number of everything
        if ((rowLimit * colLimit) !== mapString.length) {
            console.log('Invalid');
            console.log('Row limit: '+rowLimit);
            console.log('Col limit: '+colLimit);
            console.log('MapString: '+mapString.length+' - '+mapString);
            return;
        }

        // Set the counters
        let rowCounter = 0;
        let colCounter = 0;
        map = [];

        for (let key = 0; key < mapString.length; key++) {
            if (colCounter < colLimit) {
                ++colCounter;
            } else {
                colCounter = 1;
                ++rowCounter;
            }
            if (map[rowCounter] === undefined) {
                map[rowCounter] = '';
            }
            map[rowCounter] += mapString.charAt(key);
        }
        // console.log(map);

        resetTable();
// console.time('Add row');
        for(let row = 0; row < rowLimit; ++row) {
            addRow();
        }
// console.timeEnd('Add row');
// console.time('Add col');
        for (let col = 0; col < colLimit; ++col) {
            addColumn();
        }
// console.timeEnd('Add col');
// console.time('Reset tiles');
        resetTiles();
// console.timeEnd('Reset tiles');
// console.time('Activate');
        if (isViewing) {
            let tileOption = getTileOptionByName('start');
            for (let y = 0; y < rowLimit; ++y) {
                for (let x = 0; x < colLimit; ++x) {
                    if (map[y][x] == tileOption.value) {
                        let value = null;
                        if (map !== undefined && map[y] !== undefined && map[y].length > 1) {
                            value = map[y][x];
                        } else {
                            value = map[y];
                        }
                        activateTile(x, y, value);//$('#puzzle-table tr:nth-of-type('+y+') td:nth-of-type('+x+') #start').click();
                        reveal(x, y);
                    }
                }
            }
        } else {
            activateAllTiles();
        }
// console.timeEnd('Activate');
    };

    var init = function() {
        // console.time('generateTiles');
        generateTiles();
        // console.timeEnd('generateTiles');
        if ($('.puzzle.view').length == 0) {
            isViewing = true; // Awful way to set this, but currently no other way!
            // updateFromCode();
        }
    }

    $(document).on('click', '.puzzle-label', function(e) {
        e.preventDefault();
        // console.log('click!');
        let parent = $(this).parent('td');
        if (isViewing) {
            let coord = $(this).data('for').split('|');
            let x = coord[1];
            let y = coord[0];
            let tileOption = getTileOptionByName('none');
            // console.log($(this).parent('td').find('input[type=radio]:checked').val());
            // console.log(tileOption.value);
            // console.log($(this).parent('td').find('input[type=radio]:checked').val() != tileOption.value);
            if ($(this).parent('td').find('input[type=radio]:checked').val() != tileOption.value) {
                reveal(x, y);
            }
        } else {
            // console.log(parent);
            let checkedRadio = $(parent).find('input[type=radio]:checked');
            // console.log(checkedRadio);
            let checkValue = parseInt($(checkedRadio).val());
            let maxValue = tileOptions.length - 1;
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
        updateToCode();
    });

    $('#add-row').click(function() {
        addRow();
        updateToCode();
    });

    $('#generate-code').click(function() {
        updateToCode();
    });

    $('#generate-from').click(function() {
        updateFromCode();
    });

    $('#reset-tiles').click(function() {
        resetTiles();
    });

    init();
});