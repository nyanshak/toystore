$(function() {

	var last_q = '';
	var password_listener = function() {
		var current;
		current = $('#password').val();
		if (!current) {
			$('#password-result').html('');
			$('#password-result').attr('class', 'weak');
			return;
		}
		if (current !== last_q) {
			last_q = current;
			r = zxcvbn(current);

			entropy = r.entropy;
			

			result = "";
			// Entropy used to determine password strength 
			if (entropy < 30) { // too weak
				result = "Password Strength: " + entropy + " (Too Weak)";
				$('#password-result').attr('class', 'weak');
			} else if (entropy < 40) { // acceptable
				result = "Password Strength: " + entropy + " (Acceptable)";
				$('#password-result').attr('class', 'acceptable');
			} else if (entropy < 45) { // strong
				result = "Password Strength: " + entropy + " (Strong)";
				$('#password-result').attr('class', 'strong');
			} else { // very strong
				result = "Password Strength: " + entropy + " (Very Strong)";
				$('#password-result').attr('class', 'very-strong');
			}
			
			return $('#password-result').html(result);
		}
	}

	return setInterval(password_listener, 100);
});
