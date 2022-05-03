$(document).ready(function() {

$('.info:has(.address)').each(function(i, info) {
	setTimeout(function() {
		$.ajax('https://ipapi.co/'+$('.address', info).text()+'/json/')
		 .done(function (geo) {
			var d = [];
			if (geo.city) d.push(geo.city);
			if (geo.country_code == 'US' && geo.region_code) d.push(geo.region_code);
			d.push((d.length == 0) ? geo.country : geo.country_code);
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
IP: {ip}\n\
Org: {org}\n\
ASN: {asn}\n\
\n\
City: {city}\n\
Region: {region}\n\
Country: {country_name}\n\
Post Code: {postal}\n\
\n\
Lat/Long: {latitude}, {longitude}\n\
Timezone: {timezone}";

function mustachio(str, object) {
	return str.replace(/{([^}]+)}/g, function(m, key) {return object[key]});
}

});
