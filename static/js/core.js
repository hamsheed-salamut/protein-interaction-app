var callback, set_flag = false, main_gene_id;

function search(type, id) {

    switch (type) {
        case 'gene': 
        
        $.ajax({
            type: 'POST',
            url: 'database.php',
            dataType: 'json',
            data: {
                'id' : id,
                'action': type
            },
            success: function (data) {
                let options = getOptions();
                cytoscapeHelper(options, data);
            },
            error: function (data) {
                console.log(data);
            }
        });
        break;
    }
}

function cytoscapeHelper(options, data) {
    data = data.gene;

    if (data === undefined || data.main == undefined || data.main.length === 0) {
        ppi_exist = false;

        let var_nodes = [{data: {id: '0000',
                        name: 'No protein interaction network',
                        bcolor: 'red'}}];

        cytoscapeGraph(options, var_nodes, []);
    } else {
        //data.main[0].Id;
        ppi_exist = true;

        let x_pos = 100;

        let var_nodes = [{data: {id: data.main[0].ID,
                        name: data.main[0].Symbol,
                        bcolor: 'red'}}];
        
        for (var x = 0; x < data['interactors'].length; x++) {
            let temp = data['interactors'][x];
;
            var_nodes.push({data: {id   : temp.ID1,
                                   name : temp.symbol,
                                   bcolor: '#f8b739'}});
        }

        var unique_nodes = unique_fast(var_nodes), ids = [];

        for (var x = 0; x < unique_nodes.length; x++) {
            ids[ids.length] = unique_nodes[x]['data']['id'];	;
        }

        console.log(ids);

        $.ajax({
            type: 'POST',
            url: 'database-inter.php',
            dataType: 'json',
            data: {         
                'id': ids,
                'action': "interactions"
            },
            success: function (result) {
                let var_edges = [];
                
                for (var x = 0; x < result['interactions'].length; x++) {
                    var source, target;

                    if (result['interactions'][x]['id'] == data.main[0].ID) {
                        console.log('jjbjb');
                        source = result['interactions'][x]['id'];
                        target = result['interactions'][x]['id_interaction'];
                    } else {
                        source = result['interactions'][x]['id_interaction'];
                        target = result['interactions'][x]['id'];
                    }

                    var_edges.push({data: {
                        source: source,
                        target: target
                    }});
                }
                    main_gene_id = data.main.Id;
                    cytoscapeGraph(options, var_nodes, var_edges);

                },
                error: function (data) {
                    console.log(data);
                }
            
        });
    } 
}


function cytoscapeGraph(options, var_nodes, var_edges, settings) {

	
    if(settings == undefined) {
        settings = {color:undefined, display:undefined};
    }
    if(settings.color == undefined) {settings.color = 'data(bcolor)'; }
    if(settings.display == undefined) {settings.display = 'block'};

     console.log(var_edges);

    options.maxNodes = var_nodes.length;
    var uniq_nodes = unique_fast(var_nodes),
        stylesheet = cytoscape.stylesheet()
            .selector('node')
            .css({
            'content': 'data(name)',
                'text-valign': 'center',
                'color': 'white',
                'background-color': settings.color,
                'text-outline-width': 2,
                'text-outline-color': 'blue',
                'min-zoomed-font-size':5
        }) 
            .selector('edge')
            .css({
            'line-color':'green',
            'curve-style':'haystack',
            'haystack-radius': 0,
            'display': settings.display,
            
            'width': 1
        })
            .selector(':selected')
            .css({
            'background-color': 'black',
            'line-color': 'black',
            'target-arrow-color': 'black',
            'source-arrow-color': 'black'
        })
    

    options.maxNodes = uniq_nodes.length;
    options.incNodesPerCircle = 8;
  
    
    $('#cy').cytoscape({

        style: stylesheet,
        elements: {
            nodes: var_nodes
        },
        layout:options,			
        motionBlur: false,
        ready: function() {
            window.cy = this;
            
            cy.zoomingEnabled(true);

            cy.on('click', 'node', function (evt) {
                var node = evt.cyTarget;
                nodeSelect(this.data('id'));
            });

            var current_zoom = cy.zoom();
            
            $("#zoom").change(function() {
                if($(this).val() == '50' || $(this).val() == '75' || $(this).val() == '100' || $(this).val() == '125' || $(this).val() == '150' || $(this).val() == '175' || $(this).val() == '200') {
                    cy.zoom({
                      level: current_zoom * (parseInt($(this).val())/100.0), // the zoom level
                      position: { x: cy.width() / 2, y: cy.height()/2 }
                    });					cy.center();					
                }
            });
                
            $("#saveJPG").click(function() {
                console.log('save was clicked2');
                var jpg64 = cy.jpg();
                var element = document.createElement('a');
                  element.setAttribute('href', jpg64 );
                  element.setAttribute('download', 'PPI');

                  element.style.display = 'none';
                  document.body.appendChild(element);

                  element.click();

                  document.body.removeChild(element);						
                
            });

            cy.boxSelectionEnabled(true);
            cy.userZoomingEnabled(false);
            
            var numEdges = var_edges.length,
                counter = 0;

            callback = setInterval(function(){
                if(counter < numEdges) {
                
                    if(counter + 10 < numEdges) {
                        var array = var_edges.slice(counter, counter + 10),
                            temp = [];
                        for(var x = 0 ;x < array.length; x++){
                            temp.push({group:"edges", data:array[x]['data'] });
                        }
                         console.log(temp);
                        cy.add(temp);
                    } else {
                        var array = var_edges.slice(counter, numEdges),
                            temp = [];
                        for(var x = 0 ;x < array.length; x++){
                            temp.push({group:"edges", data:array[x]['data'] });
                        }
                        cy.add(temp);
                        console.log(temp);
                    }
                    counter += 10;
                } else {
                    clearInterval(callback);
                }
            }, 100);

            cy.elements().unselectify();
}});
}
            
// gets unique data from a set of data
function unique_fast(a) {
    var seen = {};
    var out = [];
    var len = a.length;
    for(var i = 0; i < len; i++) {
            var item = a[i]['data']['id'];
            if(seen[item] !== 1) {
                seen[item] = 1;
                out[out.length] = a[i];
            }
    }
    return out;
}


function getOptions(layoutName) {
    var options;
    
    switch(layoutName) {
        case 'cola':
            options = {
                name: 'cola',
                textureOnViewport:true,
                // hideEdgesOnViewport:true,
                hideLabelsOnViewport:true,
                animate: false
            };
            break;
        case 'cose':
            options = {
                name: 'cose',

                // ready               : function() {},
                // stop                : function() {},
                refresh             : 0,
                fit                 : true, 
                padding             : 30, 
                randomize           : true,
                debug               : false,
                nodeRepulsion       : 10000,
                nodeOverlap         : 10,
                idealEdgeLength     : 10,
                edgeElasticity      : 100,
                nestingFactor       : 5, 
                gravity             : 250, 
                numIter             : 100,
                initialTemp         : 200,
                coolingFactor       : 0.95, 
                minTemp             : 1
            };			
            break;
        case 'breadthfirst':
            options = {
              name: 'breadthfirst',

              fit: true, // whether to fit the viewport to the graph
              directed: false, // whether the tree is directed downwards (or edges can point in any direction if false)
              padding: 30, // padding on fit
              circle: true, // put depths in concentric circles if true, put depths top down if false
              // spacingFactor: 1.75, // positive spacing factor, larger => more space between nodes (N.B. n/a if causes overlap)
              spacingFactor: 10, // positive spacing factor, larger => more space between nodes (N.B. n/a if causes overlap)
              boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
              
              avoidOverlap: true, // prevents node overlap, may overflow boundingBox if not enough space
              roots: undefined, // the roots of the trees
              maximalAdjustments: 2, // how many times to try to position the nodes in a maximal way (i.e. no backtracking)
              animate: false, // whether to transition the node positions
              animationDuration: 500, // duration of animation in ms if enabled
              animationEasing: undefined, // easing of animation if enabled
              ready: undefined, // callback on layoutready
              stop: undefined // callback on layoutstop
            };
            break;
        case 'concentric':
        default:
            options	 = {
              name: 'concentric',

              fit: true, // whether to fit the viewport to the graph
              padding: 30, // the padding on fit
              startAngle: 3/2 * Math.PI, // where nodes start in radians
              // sweep: undefined, // how many radians should be between the first and last node (defaults to full circle)
              equidistant: false, // whether levels have an equal radial distance betwen them, may cause bounding box overflow
              minNodeSpacing: 40, // min spacing between outside of nodes (used for radius adjustment)
              boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
              avoidOverlap: true, // prevents node overlap, may overflow boundingBox if not enough space
              maxNodes: undefined,
              incNodesPerCircle: undefined,
              numNodes: 0,
              nodesCircle: 0,
              thing: 1,
              concentric: function(node){ // returns numeric value for each node, placing higher nodes in levels towards the centre
              
                var foo = options.maxNodes;
                
                if(options.numNodes >= options.nodesCircle) {
                    options.numNodes = 0;
                    options.nodesCircle += options.incNodesPerCircle;
                    options.maxNodes--;
                }
                
                options.numNodes++;
                return foo;
                
              },
              levelWidth: function(nodes){ // the variation of concentric values in each level
                return 1;
              },
              animate: false, // whether to transition the node positions
              animationDuration: 500, // duration of animation in ms if enabled
              animationEasing: undefined, // easing of animation if enabled
              ready: undefined, // callback on layoutready
              stop: undefined // callback on layoutstop
            };
            break;
    }
    return options;
    
}

function nodeSelect(id) {
    console.log('I am the id ' + id);
    var pdbId;
    var pdbArray;

    $.ajax({
        type: 'POST',
        url: 'protein-structure.php',
        dataType: 'json',
        data: {         
            'id': id,
            'action': "proteininfo"
        },
        success: function (data) {
             //console.log(data);
            for (var i = 0; i < data['proteininfo'].length; i++) {

                var pdbList = data['proteininfo'][i].PDB;

                pdbArray = pdbList.split(';');

                //console.log(data['proteininfo'][i].PDB);
            }
            
            pdbId = pdbArray[0].substring(0, pdbArray[0].length - 2);
            console.log('The pdb is ' + pdbId);
            window.open('jsmol.php?pid=' + pdbId,'popUpWindow','height=700,width=600,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');

        },
        error: function (data) {
            console.log(data);
        }
    });
    
}

function setPDB(data) {
		
    if(data !== undefined && data.length !== 0) {
        Jmol._isAsync = false;
        var jmolApplet0;
        var s = document.location.search;
        Jmol._debugCode = (s.indexOf("debugcode") >= 0);
        
        jmol_isReady = function(applet) {
            // document.title = (applet._id + " - Jmol " + Jmol.___JmolVersion);
            jmolApplet0 = applet;
            

            var colors = 'select carbon; color gray;select nitrogen; color blue;select oxygen; color red;select sulfur; color yellow;';
                
            $("#jsmol_dropdown").change(function() {
                Jmol.script(applet,"set frank off; select all; hbonds off; spin off; wireframe off; spacefill off; trace off; set ambient 40; set specpower 40; slab off; ribbons off; cartoons off; label off; monitor off");
                Jmol.script(applet,'Select all; ;ribbon only;'+colors);
                
                switch($(this).val()) {
                    case '1': // bal and stick
                        Jmol.script(applet,'select all; spacefill 23%; wireframe 0.15;');
                        break;
                    case '2': // spacefill
                        Jmol.script(applet,'select all;spacefill only;');
                        break;
                    case '3': // wirefram
                        Jmol.script(applet,'select all;Wireframe only');
                        break;
                    case '4': // ribbon
                        Jmol.script(applet,'Select all; ;ribbon only; color group;');
                        break;
                    case '5': // Backbone
                        Jmol.script(applet,'Select all; Backbone only;');
                        break;
                    case '6': // Trace
                        Jmol.script(applet,'Select all; Trace only;');
                        break;				
                }
            });
            
            
            
            var a = sessionStorage.getItem("sent");

            $.ajax({
                url:'static/pdb/pdb3aln.ent',
                // url:'static/pdb/pdb4tkh.ent',
                type:'HEAD',
                error: function()
                {
                    //file not exists
                    console.log('pdb file does not exist');
                    $("#jsmol_dropdown").css("display","none");
                    $("#jsmol_panel").html('<p>PDB file "3aln.ent" does not exist</p>');
        
                },
                success: function()
                {
                    var colors = 'select carbon; color gray;select nitrogen; color blue;select oxygen; color red;select sulfur; color yellow;';
                    
                    console.log('pdb file exists');
                    $("#jsmol_dropdown").css("display","block");
                    $("#jsmol_description").text("");
                    Jmol.script(jmolApplet0,'load static/pdb/pdb3aln.ent; Select all; ;ribbon only; color group;');
                    // Jmol.script(applet,'Select all; ;ribbon only;'+colors);
                    // Jmol.script(jmolApplet0,'load static/pdb/pdb4tkh.ent');
                }
            });			
        }
        var Info = {
            width: $('#jsmol_panel').width(),
            height: $('#jsmol_panel').width(),
            debug: false,
            color: "0xE5E5E5",
            addSelectionOptions: false,
            use: "HTML5",   // JAVA HTML5 WEBGL are all options
            j2sPath: "static/js/jsmol/j2s", // this needs to point to where the j2s directory is.
            script: "set antialiasDisplay;",
            serverURL: "http://chemapps.stolaf.edu/jmol/jsmol/php/jsmol.php",
            readyFunction: jmol_isReady,
            disableJ2SLoadMonitor: true,
            disableInitialConsole: true,
            allowJavaScript: true
            //defaultModel: "$dopamine",
            //console: "none", // default will be jmolApplet0_infodiv, but you can designate another div here or "none"
        }

        
        $("#jsmol_panel").html(Jmol.getAppletHtml("jmolApplet0", Info));
            
    }	
    // } $('#PDB_tag').attr('data-pdbcode',data[0].pdb_code);
    else {
        $("#jsmol_panel").html('<p>No structure found...</p>');
        
    }
    // $('#PDB_tag').attr('data-pdbcode', false);
    
    
    
    
}