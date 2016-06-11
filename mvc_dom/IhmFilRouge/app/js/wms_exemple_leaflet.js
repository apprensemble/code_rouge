wms = {
  knownServices: {},
  //invokes "callback" with the parsed capabilities as only parameters
  capabilities: function (url, callback) {
    var cached = wms.knownServices[url];
    if (cached) {
      callback(cached);
    } else {
      wms.getCapabilitiesDocument(url, function (xml) {
        var capabilities = wms.parseCapabilitiesDocument(xml, url);
        // cache the parsed document
        wms.knownServices[url]= capabilities ;

        // call again trusting it's already cached
        wms.capabilities(url, callback);
      });
    }
  },
  // Taken from http://davidwalsh.name/convert-xml-json
  // Changes XML to JSON
  xmlToJson: function (xml) {
    // Create the return object
    var obj = {};

    if (xml.nodeType == 1) { // element
      // do attributes
      if (xml.attributes.length > 0) {
        obj["@attributes"] = {};
        for (var j = 0; j < xml.attributes.length; j++) {
          var attribute = xml.attributes.item(j);
          obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
        }
      }
    } else if (xml.nodeType == 3) { // text
      obj = xml.nodeValue;
    }

    // do children
    if (xml.hasChildNodes()) {
      for (var i = 0; i < xml.childNodes.length; i++) {
        var item = xml.childNodes.item(i);
        var nodeName = item.nodeName;
        if (typeof (obj[nodeName]) == "undefined") {
          obj[nodeName] = wms.xmlToJson(item);
        } else {
          if (typeof (obj[nodeName].push) == "undefined") {
            var old = obj[nodeName];
            obj[nodeName] = [];
            obj[nodeName].push(old);
          }
          obj[nodeName].push(wms.xmlToJson(item));
        }
      }
    }
    return obj;
  },
  // analyse du GetCapabilies de l'objet json
  getCapabilitiesDocument: function (url, callback) {
    var wms_uri = url;
    console.log("wms.getCapabilitiesDocument()")
    $.get(wms_uri, function (xml) {
      callback(xml);
    }).fail(function () {
      $.error("erreur $.get");
    });
  },
  parseCapabilitiesDocument: function (xml, url) {
    var _this = this;
    var capabilities = {};
    return wms.xmlToJson(xml);

  },
// recherche du layer
  layer: function(capabilities, layerName) {
    console.log("wms.layer() %s", layerName)
    var layers =  capabilities.WMS_Capabilities.Capability.Layer.Layer;
    layers =  layers.filter(function(layer) {return layer.Name["#text"] == layerName });
    return layers[0];
  },
// il peut yi avoir plusieurs BoundingBox
  layerBounds: function (capabilities, layerName) {
    var layer = wms.layer(capabilities, layerName);
    if (layer.BoundingBox instanceof Array) {
      console.log("wms.layerBounds() layer.BoundingBox nb: %s", layer.BoundingBox.length)
      return layer.BoundingBox[0]["@attributes"];
    } else {
      return layer.BoundingBox["@attributes"];
    }
  }
};