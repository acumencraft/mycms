# DATABASE.md

Archvadze Web Agency Platform Database Specification

## Database Engine

MySQL / MariaDB

Charset:  
utf8mb4

Collation:  
utf8mb4_unicode_ci

---

# Core System

## users

Fields:

id  
name  
email  
password  
role_id  
status  
email_verified_at  
created_at  
updated_at

Indexes:

email UNIQUE

---

## roles

id  
name  
description  
created_at  
updated_at

Example roles:

super_admin  
admin  
editor  
support  
client

---

## permissions

id  
name  
description

---

## role_permissions

id  
role_id  
permission_id

---

# Client System

## clients

id  
name  
email  
phone  
company  
country  
created_at  
updated_at

---

## client_notes

id  
client_id  
note  
created_by  
created_at

---

# Orders

## orders

id  
client_name  
email  
phone  
domain  
website_type  
price_estimate  
status  
created_at  
updated_at

Statuses:

pending  
contacted  
accepted  
rejected

---

## order_services

id  
order_id  
service_id

---

## order_features

id  
order_id  
feature_id

---

# Projects

## projects

id  
client_id  
title  
description  
status  
price  
deadline  
created_at  
updated_at

Statuses:

pending  
in_progress  
review  
completed

---

## project_tasks

id  
project_id  
title  
description  
status  
assigned_to  
deadline

---

## project_messages

id  
project_id  
sender_id  
message  
created_at

---

## project_files

id  
project_id  
file_path  
uploaded_by  
created_at

---

# Services

## services

id  
name  
description  
base_price  
icon  
status  
created_at  
updated_at

---

## features

id  
name  
description  
price

Examples:

Multilingual  
Booking System  
SEO Package  
Admin Panel

---

# Portfolio

## portfolio_projects

id  
title  
description  
project_url  
technologies  
created_at

---

## portfolio_images

id  
project_id  
image_path

---

# Publications

## publications

id  
title  
slug  
content  
author_id  
status  
published_at  
created_at

Statuses:

draft  
published

---

## publication_categories

id  
name  
slug

---

## publication_tags

id  
name  
slug

---

## publication_tag_map

id  
publication_id  
tag_id

---

# Guides

## guides

id  
title  
slug  
content  
category_id  
published_at

---

## guide_categories

id  
name  
slug

---

# FAQ

## faq

id  
question  
answer  
category_id

---

## faq_categories

id  
name

---

# CMS Pages

## pages

id  
title  
slug  
content  
seo_title  
seo_description  
status

---

# Testimonials

## testimonials

id  
client_name  
company  
photo  
rating  
testimonial_text

---

# Contact System

## contact_messages

id  
name  
email  
subject  
message  
created_at

---

# Newsletter

## newsletter_subscribers

id  
email  
status  
created_at

---

# Poll System

## polls

id  
question  
status  
created_at

---

## poll_options

id  
poll_id  
option_text

---

## poll_votes

id  
poll_id  
option_id  
ip  
created_at

---

# Media

## media

id  
file_name  
file_path  
type  
size  
uploaded_by  
created_at

---

# Settings

## site_settings

id  
key  
value

Example keys:

site_name  
site_email  
office_address  
latitude  
longitude  
phone  
working_hours

---

# Logs

## activity_logs

id  
user_id  
action  
entity  
entity_id  
created_at

---

# Analytics

## visits

id  
ip  
page  
referrer  
created_at

---

## domain_search_logs

id  
domain  
ip  
created_at

---

End of database specification.
