# Mass-Joomla-com_civicrm-remote-code-Injection-
This tool is a proof‑of‑concept exploit script targeting the legacy Joomla CiviCRM component (com_civicrm) OpenFlashChart upload functionality. It automates the upload of a crafted payload to the vulnerable ofc_upload_image.php endpoint and attempts to gain remote command execution via the generated PHP file. The script supports both single‑target mode and multi‑target mode using a list file, making it suitable for controlled lab environments and educational ethical hacking exercises focused on exploit development, automation, and legacy web application security.

This tool is intended strictly for authorized security testing, research, and training in isolated labs or with explicit written permission from the system owner. Unauthorized use against systems you do not own or manage is illegal and unethical.

## Usage

This script is a command‑line PHP tool and supports both single‑target and multi‑target modes.

# Single target mode
php civicrm_ofc_rce.php -u http://target.com/ -f post.php

# Multi‑target mode (one URL per line in list.txt)
php civicrm_ofc_rce.php -l list.txt -f post.php
