# lbaw24113

Scrumbled fosters an environment where agile project management is approachable and straightforward while enabling teams to adopt and master the Scrum methodology with ease. Improving team collaboration is key, with each sprint serving as an opportunity for effective, transparent, and targeted advancement.

Scrumbled is a project management website, designed to use the Scrum Framework. It is easy to use and helps users follow Scrum practices to ensure a good team collaboration.

### 1. Installation

The final version of the Docker image can be found [here](gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24113), this needs to be used with the command below.

### Using Mailtrap
In order to view the emails sent to Mailtrap, we have created a test account.
Note that Mailtrap has a limit of 100 monthly emails for the free version.

The Gmail account for mailtrap has the following credentials:
- Email: ``scrumbledTest@gmail.com`` 
- Password: ``Scrum6L3dT35t`` 

The ``.env`` that we published in repository is linked to this account in Mailtrap. Using it with a different account will not work without changing the ``.env`` file.

To run it use this bash command:

```bash
$ docker run -d --name lbaw2425 -p 8001:80 gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24113
```

### 2. Usage

#### 2.1. Administration Credentials

In order to access the admin page, append ``/admin`` to the base URL.  

| Username        | Password |
| --------------- | -------- |
| admin@email.com | password |

#### 2.2. User Credentials

| Type                       | Username          | Password |
| -------------------------- | ----------------- | -------- |
| Product Owner of Jira      | up202207919@up.pt | password |
| Product Owner of Scrumbled | up202205469@up.pt | password |
| Scrum Master of Jira       | up202205794@up.pt | password |
| Developer in Jira          | up202206370@up.pt | password |

### 3. Video presentation

The video presentation can be found in the repository's docs folder. You can access it by clicking [here](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24113/-/blob/3a9a701d4e626682631c526d8e38d8743f7bb353/docs/ScrumbledDemoVideoV2.mp4).


---


## Revision history

No revision history yet.

---

GROUP24113, 25/11/2024

* António Santos, up202205469@up.pt
* Vanessa Queirós, up202207919@up.pt
* João Santos, up202205794@up.pt
* Simão Neri, up202206370@up.pt