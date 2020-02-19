jQuery(document).ready(function($) {
    var mapJson;
    var tileTemplate = '<div class="puzzle-piece" data-row="{{row}}" data-col="{{col}}" data-coordinate-value="{{value}}"></div>';
    var tileOptions = [
        {
            name: 'wall',
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

    var activateTile = function (colKey, $row, value) {
        // console.log('You clicked - X:'+x+'; Y:'+y+'; Value:'+value+'; Target - X:'+(x+1)+'; Y:'+(y+1)+';');
        colFindKey     = ++colKey;
        $puzzlePiece   = $($row).find('td:nth-of-type('+colFindKey+')').find('div.puzzle-piece');        
        let tileOption = getTileOptionByValue(value);
        $($puzzlePiece)
            .addClass('puzzle-piece-'+tileOption.name)
            .data('coordinateValue', value)
            .attr('data-coordinate-value', value);
    }

    var activateAllTilesForEditing = function (mapJson, $puzzleTable) {
        // console.time('Loop rows');
        $(mapJson.coordinateValues).each(function(rowKey, rowArray) {
            let $row = $($puzzleTable).find('tr:nth-of-type('+(rowKey+1)+')');
            // console.time('Loop cols');
            for (let colKey = 0; colKey < mapJson.colCount; ++colKey) {
                let coordinateValue = rowArray[colKey];
                // console.time('activate tile');
                activateTile(colKey, $row, coordinateValue);
                // console.timeEnd('activate tile');
            };
            // console.timeEnd('Loop cols');
        });
        // console.timeEnd('Loop rows');
    }

    var activateAllTilesForViewing = function (mapJson, $puzzleTable) {
        let tileOption = getTileOptionByName('start');
        $(mapJson.coordinateValues).each(function(rowKey, rowArray) {
            let rowFindKey = rowKey + 1;
            let $row       = $($puzzleTable).find('tr:nth-of-type('+rowFindKey+')');

            for (let colKey = 0; colKey < mapJson.colCount; ++colKey) {
                coordinateValue = rowArray[colKey];

                if (coordinateValue == tileOption.value) {
                    activateTile(colKey, $row, coordinateValue);//$('#puzzle-table tr:nth-of-type('+rowKey+') td:nth-of-type('+colKey+') #start').click();
                    reveal($puzzleTable, mapJson, colKey, rowKey);
                } else {
                    activateTile(colKey, $row, 0);
                }
            }
        });
    }

    var generateTile = function(rowCount, colCount) {
        return tileTemplate
            .replace(/{{row}}/g, rowCount)
            .replace(/{{col}}/g, colCount)
            .replace(/{{value}}/g, '0')
            .replace(/{{.*?}}/g, '');
    }

    var addColumn = function($puzzleTable, colNumber) {
        let $rows = $($puzzleTable).find('tr');
        let rowCount = 0;
        $($rows).each(function() {
            let tile = generateTile(rowCount, colNumber);
            $(this).append('<td>' + tile + '</td>');
            rowCount++;
        });
    };

    var addRow = function($puzzleTable, rowNumber, colCount) {
        $($puzzleTable).append('<tr></tr>');
        let $row = $($puzzleTable).find('tr:last-child');
        for (let i = 0; i < colCount; i++) {
            let tile = generateTile(rowNumber, i);
            $($row).append('<td>' + tile + '</td>');
        }
    };

    var resetTable = function($puzzleTable, mapJson) {
        $($puzzleTable).find('tr').remove();

        noOfRows = 0;
        noOfCols = 0;
    }

    var resetTiles = function($puzzleTable) {
        let puzzlePieces = $($puzzleTable).find('tr td').find('div.puzzle-piece');
        $(puzzlePieces).each(function() {
            let pieceValue = $(this).data('coordinateValue');
            if (pieceValue) {
                $(this).removeClass('puzzle-piece-'+getTileOptionByValue(pieceValue).name);
                $(this).data('coordinateValue', null);
            }
        });
    }

    var reveal = function($puzzleTable, mapJson, x, y) {
        console.time('Reveal');
        console.log('x:' + x +'; y: '+ y);
        if (y > 0) {
            revealUp($puzzleTable, mapJson, x, y);
        }

        if (y < mapJson.rowCount) {
            revealDown($puzzleTable, mapJson, x, y);
        }

        if (x > 0) {
            revealLeft($puzzleTable, mapJson, x, y);
        }

        if (x < mapJson.colCount) {
            revealRight($puzzleTable, mapJson, x, y);
        }
        console.timeEnd('Reveal');
    }

    var revealUp = function($puzzleTable, mapJson, selectedCol, selectedRow) {
        for (let i = selectedRow; i >= 0; --i) {
            let value      = mapJson.coordinateValues[i][selectedCol];
            let tileOption = getTileOptionByValue(value);
            let rowFindKey = i + 1;
            let $row       = $($puzzleTable).find('tr:nth-of-type('+rowFindKey+')');

            if (tileOption.empty) {
                activateTile(selectedCol, $row, tileOption.value);
            } else if (i != selectedRow) {
                activateTile(selectedCol, $row, tileOption.value);
                break;
            }
        }
    }

    var revealDown = function($puzzleTable, mapJson, selectedCol, selectedRow) {
        for (let i = selectedRow; i < mapJson.rowCount; ++i) {
            console.log('i '+i);
            console.log('selectedCol '+selectedCol);
            console.log(mapJson);
            console.log(mapJson.coordinateValues);
            console.log(mapJson.coordinateValues[i]);
            console.log(mapJson.coordinateValues[i][selectedCol]);
            let value      = mapJson.coordinateValues[i][selectedCol];
            let tileOption = getTileOptionByValue(value);
            let rowFindKey = i + 1;
            let $row       = $($puzzleTable).find('tr:nth-of-type('+rowFindKey+')');

            if (tileOption.empty) {
                activateTile(selectedCol, $row, tileOption.value);
            } else if (i != selectedRow) {
                activateTile(selectedCol, $row, tileOption.value);
                break;
            }
        }
    }

    var revealLeft = function($puzzleTable, mapJson, selectedCol, selectedRow) {
        let rowFindKey = selectedRow + 1;
        let $row       = $($puzzleTable).find('tr:nth-of-type('+rowFindKey+')');
        for (let i = selectedCol; i >= 0; --i) {
            let value      = mapJson.coordinateValues[selectedRow][i];
            let tileOption = getTileOptionByValue(value);

            if (tileOption.empty) {
                activateTile(i, $row, tileOption.value);
            } else if (i != selectedCol) {
                activateTile(i, $row, tileOption.value);
                break;
            }
        }
    }

    var revealRight = function($puzzleTable, mapJson, selectedCol, selectedRow) {
        let rowFindKey = selectedRow + 1;
        let $row       = $($puzzleTable).find('tr:nth-of-type('+rowFindKey+')');
        for (let i = selectedCol; i <= mapJson.colCount; ++i) {
            let value      = mapJson.coordinateValues[selectedRow][i];
            let tileOption = getTileOptionByValue(value);

            if (tileOption.empty) {
                activateTile(i, $row, tileOption.value);
            } else if (i != selectedCol) {
                activateTile(i, $row, tileOption.value);
                break;
            }
        }
    }

    var updateToCode = function($puzzleTable) {
        mapJson = {
            "colCount": 0,
            "rowCount": 0,
            "coordinateValues": []
        }
        map = [];
        $($puzzleTable).find('tr').each(function() {
            mapJson.colCount = 0;
            mapJson.coordinateValues[mapJson.rowCount] = new Array();
            $(this).find('div.puzzle-piece').each(function() {
                mapJson.coordinateValues[mapJson.rowCount].push($(this).data('coordinateValue'));
                ++mapJson.colCount;
            });
            ++mapJson.rowCount;
        });

        $('#map').val(JSON.stringify(mapJson));
    };

    var updateFromCode = function() {
        console.time('start up');

        mapJson = JSON.parse($('#map').val());
        console.log(mapJson);

        if (!validateMapJson(mapJson)) {
            console.log('Sorry, not valid JSON');
            return false;
        }

        let $puzzleTable = $('#puzzle-table');

        // Reset the whole table for the puzzle
        resetTable($puzzleTable);

        // Add all of the rows first - for optimised performance
        console.time('Add rows');
        for(let row = 0; row < mapJson.rowCount; ++row) {
            addRow($puzzleTable, row, mapJson.colCount);
        }
        console.timeEnd('Add rows');

        // Reset the tiles on the puzzle
        console.time('Reset tiles');
        resetTiles($puzzleTable);
        console.timeEnd('Reset tiles');

        // Activate the tiles we need for if this is editing or viewing it
        console.time('Activate');
        if (isViewing) {
            activateAllTilesForViewing(mapJson, $puzzleTable);
        } else {
            activateAllTilesForEditing(mapJson, $puzzleTable);
        }
        console.timeEnd('Activate');
    };

    var validateMapJson = function(mapJson) {
        // Check that we have the right number of everything
        if (mapJson.coordinateValues.length !== mapJson.rowCount) {
            console.log('Invalid row count');
            console.log('Row count specified: '+mapJson.rowCount);
            console.log('Actual row count: '+mapJson.coordinateValues.length);
            return false;
        }

        $(mapJson.coordinateValues).each(function (key, value) {
            if (value.length !== mapJson.colCount) {
                console.log('Invalid');
                console.log('Col count specified: '+colCount);
                console.log('Actual col count: '+value.length);
                return false;
            }
        });

        return true;
    }

    var init = function() {
        if ($('.puzzles.view').length > 0) {
            isViewing = true; // Awful way to set this, but currently no other way!
        }
    }

    $(document).on('click', '.puzzle-piece', function(e) {
        let $puzzleTable = $('#puzzle-table');
        if (isViewing) {
            let coordinateValue = parseInt($(this).data('coordinateValue'));
            let x = parseInt($(this).data('col'));
            let y = parseInt($(this).data('row'));
            let tileOption = getTileOptionByValue(coordinateValue);

            reveal($puzzleTable, mapJson, x, y);
        } else {
            let coordinateValue = parseInt($(this).data('coordinateValue'));
            let x = parseInt($(this).data('col'));
            let y = parseInt($(this).data('row'));
            let maxValue = tileOptions.length - 1;
            let nextCoordinateValueSelection = coordinateValue + 1;
            if (nextCoordinateValueSelection > maxValue) {
                nextCoordinateValueSelection = 0;
            }
            tileOption = getTileOptionByValue(coordinateValue);
            $(this).removeClass('puzzle-piece-'+tileOption.name);
            let $row = $(this).closest('tr');
            activateTile(x, $row, nextCoordinateValueSelection);
            updateToCode($puzzleTable);
        }
    });

    $('#add-column').click(function() {
        ++mapJson.colCount;
        addColumn($('#puzzle-table'), mapJson.colCount);
        updateToCode();
    });

    $('#add-row').click(function() {
        ++mapJson.rowCount;
        addRow($('#puzzle-table'), mapJson.rowCount, mapJson.colCount);
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