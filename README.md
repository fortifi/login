# Login Cookies

The fortifi login cookie is built to serve as the first line of detection to the
currently logged in user.

Where required, you should always add additional levels of security to verify 
the user described within the cookie is the user connecting to your service.

## Cookie Rules
- HttpOnly should be enabled
- Secure should be used where possible
- Cookie should be base64 encoded and urlencoded to avoid transport issues

## Cookie Validation
- The token should be sent to the fortifi api to verify the token is still valid
- Should always verify the users cookie
- Cookie should be verified against the current user IP
- Should check to see if the token has not expired, if it has, actions should be
taken for the token to be refreshed
