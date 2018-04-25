//Registering handlebar helpers for arithmatic operations
	Handlebars.registerHelper("math", function(lvalue, operator, rvalue, options) {
		if (arguments.length < 4) {
			// Operator omitted, assuming "+"
			options = rvalue;
			rvalue = operator;
			operator = "+";
		}
			
		lvalue = parseFloat(lvalue);
		rvalue = parseFloat(rvalue);
			
		return {
			"+": lvalue + rvalue,
			"-": lvalue - rvalue,
			"*": lvalue * rvalue,
			"/": (lvalue / rvalue).toFixed(2),
			"%": (lvalue % rvalue).toFixed(2)
		}[operator];
	});
	
	//created for unitprice calculations and stringify object on simulation
	//contextObj holds main response object or decoration object (depends on value of action)
	Handlebars.registerHelper("operate", function(contextObj,action){
		
		if (typeof contextObj !== "object") return;
		
			
		var totqty = 0;
		$.each(contextObj.Products, function(prodIndex,prodObj){ //calculate total quantity
					totqty = totqty + prodObj.qty;
				});
		
		if (action === "methodobj") {
			var decoObj = {}; //$.extend(true,{},contextObj);
			decoObj.decoration_id = contextObj.decoration_id;
			//decoObj.idorn  = contextObj.idorn; we have configuration_id now
			//decoObj.idlon  = contextObj.idlon;
			//decoObj.idmen  = contextObj.idmen;
			var sku = contextObj.image_sku;
			decoObj.configuration_id = sku.substr( sku.indexOf('_') + 1);
			decoObj.qty = totqty;
			decoObj.idcon  = contextObj.idcon;
			decoObj.colors = contextObj.colors;
			decoObj.length = contextObj.length; 
			decoObj.width  = contextObj.width;
			decoObj.diameter = contextObj.diameter;
			console.log(JSON.stringify(decoObj));
			return JSON.stringify(decoObj);			
		}
		
				
		switch(action){
			case "unitpricetotal":					
				return (contextObj.grandtotal/totqty).toFixed(2);
				break;
			case "unitpricesub":
				return (contextObj.subtotal/totqty).toFixed(2);
				break;
			case "unitpricevat":
				return (contextObj.vat/totqty).toFixed(2);
				break;
		}
		
	});
	Handlebars.registerHelper("tostring", function(param){
		if(typeof(param) === "object" )
			return JSON.stringify(param);
		else 
			return param.toString();
	});
	
	(function() {
    function checkCondition(v1, operator, v2) {
        switch(operator) {
            case '==':
                return (v1 == v2);
            case '===':
                return (v1 === v2);
            case '!==':
                return (v1 !== v2);
            case '<':
                return (v1 < v2);
            case '<=':
                return (v1 <= v2);
            case '>':
                return (v1 > v2);
            case '>=':
                return (v1 >= v2);
            case '&&':
                return (v1 && v2);
            case '||':
                return (v1 || v2);
			case 'startsWith':
				return (v1.startsWith(v2));
            default:
                return false;
        }
    }

    Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
        return checkCondition(v1, operator, v2)
                    ? options.fn(this)
                    : options.inverse(this);
		});
	}());
