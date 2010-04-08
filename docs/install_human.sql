--
-- PostgreSQL database example
--
-- IT'S JUST EXAMPLE!!!

CREATE TABLE bottles (
id SERIAL PRIMARY KEY, 
name text UNIQUE,
description text,
img_src text);

CREATE TABLE beverages (                                                              
id SERIAL PRIMARY KEY, 
name text UNIQUE,
description text
);

CREATE TABLE filled_bottles (
id SERIAL PRIMARY KEY, 
name text,
bottle_id integer REFERENCES bottles (id) ON DELETE CASCADE,
beverage_id integer REFERENCES beverages (id) ON DELETE CASCADE);

INSERT INTO bottles (name, description, img_src) VALUES ('квадратная', 'обыкновенная квадратная бутылка', 'square.png');
INSERT INTO bottles (name, description, img_src) VALUES ('широкая', 'очень широкая бутылка', 'wide.png');
INSERT INTO bottles (name, description, img_src) VALUES ('tall', 'высокая узкая бутылка', 'tall.png');

INSERT INTO beverages (name, description) VALUES ('сидр', 'отличный русский напиток');

INSERT INTO filled_bottles (name, bottle_id, beverage_id) VALUES ('специально для ненасти', 2, 1);