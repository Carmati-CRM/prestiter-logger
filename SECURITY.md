# Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability within this package, please send an email to info@prestiter.it.

All security vulnerabilities will be promptly addressed.

Please do not disclose security-related issues publicly until a fix has been released.

## Security Best Practices

When using this library:

1. **API Keys**: Never commit API keys (e.g., New Relic API key) to version control. Use environment variables.

2. **Log Content**: Be careful not to log sensitive data (passwords, tokens, PII) in the payload field.

3. **File Permissions**: When using FileDriver, ensure log files have appropriate permissions and are not publicly accessible.
