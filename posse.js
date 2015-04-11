$(document).ready(function() {

$('.info:has(.address)').each(function(i, info) {
	setTimeout(function() {
		$.ajax('http://ip-api.com/json/'+$('.address', info).text())
		 .done(function (geo) {
			var d = [];
			if (geo.city) d.push(geo.city);
			if (geo.countryCode == 'US' && geo.region) d.push(geo.region);
			d.push((d.length == 0) ? geo.country : geo.countryCode);
			var summary = d.join(", ") + (geo.org ? ": " + geo.org : "");
			if (! summary) summary = geo.ip;
			var full = summary + "\n\n" + mustachio(full_description, geo);
			$('.address', info).text(summary);
			$(info).attr('TITLE', full);

		});
	},
	i*500);
});

var full_description ="\
IP: {query}\n\
Org: {org}\n\
ISP: {isp}\n\
AS: {as}\n\
\n\
City: {city}\n\
Region: {regionName}\n\
Country: {country}\n\
Post Code: {zip}\n\
\n\
Lat/Long: {lat}, {lon}\n\
Timezone: {timezone}";

function mustachio(str, object) {
	return str.replace(/{([^}]+)}/g, function(m, key) {return object[key]});
}

});
