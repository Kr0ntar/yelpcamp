CREATE TABLE campers (
	id int not null auto_increment,
	email varchar(255) not null,
	username varchar(100) not null,
	password varchar(100) not null,
	PRIMARY KEY (id)
);

CREATE TABLE camp_posts (
	id int not null auto_increment,
	user_id int not null,
	username varchar(100) not null,
	title varchar(100) not null,
	description text not null,
	img_link varchar(500) not null,
	post_date datetime not null,
	PRIMARY KEY (id)
);

CREATE TABLE comments (
	id int not null auto_increment,
	user_id int not null,
	post_id int not null,
	username varchar(100) not null,
	comment text not null,
	comment_date datetime not null,
	PRIMARY KEY (id)
);

CREATE TABLE edit_comment_history (
	id int not null auto_increment,
	comment_id int not null,
	post_id int not null,
	user_id int not null,
	username varchar(100) not null,
	updated_comment text not null,
	updated_comment_date datetime not null,
	PRIMARY KEY (id)
);