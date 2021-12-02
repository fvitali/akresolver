var lcm = {}

lcm.FeatureList = function(uri) {
	this["@context"] =  [
		"http://www.fabiovitali.it/legalcitem/lcm-context7.json",
		"http://www.fabiovitali.it/legalcitem/lcm-local.json"
	];
	this["citation"] = {
		"details": { "text": uri }
	}
	this["references"] = [ {
		"features": [ ]
	} ]
	this.add = function(name,value,level,frame) {
		this.references[0].features.push({
			"name": name,
			"frame": frame,
			"frbr": level,
			"levels": { "values": value }
		})
	}
	return this
}

var boecli = (function() {
	var languages = ["ita","eng","esp","deu","fra"] ;
	var formats = ["html","xml","pdf","txt","doc","docx"] ;
	var featureMapping = {
		"syntax" : 0,
		"country" : 1,
		"court": 2,
		"year": 3,
		"number" : 4,
		"publisher": 5,
		"language" : 6,
		"version" : 7,
		"format": 8,
		"fragment": 9
	} ;
	 
	return {
		analyzeLCM: function(ecli) {
			var parse = this.parse(ecli) ;
			var feat = new lcm.FeatureList(ecli) 
			feat.add("syntax", parse[0][0][0], "work","source" ); 
			feat.add("country", parse[0][0][1], "work","source"); 
			feat.add("court", parse[0][0][2], "work","source"); 
			feat.add("year", parse[0][0][3], "work","source"); 
			feat.add("number", parse[0][0][4], "work","source"); 
			for (var i=1; i<parse[0].length;i++) {
				for (var j=0; j< parse[0][i].length; j++) {
					var item = parse[0][i][j].toLowerCase() ;
					if (languages.indexOf(item) !== -1) {
						feat.add("language", item, "expression","source"); 
					} else if (formats.indexOf(item) !== -1) {
						feat.add("format", item, "manifestation","source"); 
					} else if (item.match(/v\d+/) ) {
						feat.add("version", item, "expression","source"); 
					} else {
						feat.add("publisher", item, "expression","source"); 
					}
				}
			}
			if (parse[1]) {
				feat.add("fragment", parse[1], "work","source") ; 
			}
			return JSON.stringify(feat,null,"  "); 
		},
		analyze: function(ecli) {
			var parse = this.parse(ecli) ;
			var feat = {}
			feat["syntax"] = parse[0][0][0]; 
			feat["country"] = parse[0][0][1]; 
			feat["court"] = parse[0][0][2]; 
			feat["year"] = parse[0][0][3]; 
			feat["number"] = parse[0][0][4]; 
			for (var i=1; i<parse[0].length;i++) {
				for (var j=0; j< parse[0][i].length; j++) {
					var item = parse[0][i][j].toLowerCase() ;
					if (languages.indexOf(item) !== -1) {
						feat["language"] = item; 
					} else if (formats.indexOf(item) !== -1) {
						feat["format"] = item; 
					} else if (item.match(/v\d+/) ) {
						feat["version"] = item; 
					} else {
						feat["publisher"] = item; 
					}
				}
			}
			if (parse[1]) {
				feat["fragment"] = parse[1] ; 
			}
			return JSON.stringify(feat,null,"  "); 
		},
		convert: function(ecli) {
//			var parse = this.parse(ecli) ;
//			return parse[0][0].join(":"); 
// 			... or, even simpler: 
			return ecli.split("(")[0]
		}, 
		generate: function(json) {
			try {
				var featureList = JSON.parse(json);
				var out = ["ECLI","???","???","???","???"]
				if (featureList['@context']) {
					var feats = featureList.references[0].features
					for (var i=0; i < feats.length; i++) {
						if (featureMapping[feats[i].name]) {
							out[featureMapping[feats[i].name]] = feats[i].levels.values
						}
					}
				} else {
				
				}
				return out.join(':')
			} catch(e) {
				alert(e); // error in the above string (in this case, yes)!
			}
		},
		parse: function(ecli) {
			var parse = ecli.replace(/\)/g,"").split(/#/)
			parse[0] = parse[0].split(/\(:?/)
			parse[0].forEach(function(v,i,a){ 
				a[i] = v.split(/:/) ;
			})
			return parse ;		
		}

	} ; 
})() ; 