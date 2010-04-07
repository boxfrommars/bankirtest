--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: beverages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE beverages (
    id integer NOT NULL,
    name text,
    description text
);


ALTER TABLE public.beverages OWNER TO postgres;

--
-- Name: beverages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE beverages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.beverages_id_seq OWNER TO postgres;

--
-- Name: beverages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE beverages_id_seq OWNED BY beverages.id;


--
-- Name: beverages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('beverages_id_seq', 22, true);


--
-- Name: bottles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE bottles (
    id integer NOT NULL,
    name text,
    description text,
    img_src text
);


ALTER TABLE public.bottles OWNER TO postgres;

--
-- Name: bottles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE bottles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.bottles_id_seq OWNER TO postgres;

--
-- Name: bottles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE bottles_id_seq OWNED BY bottles.id;


--
-- Name: bottles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('bottles_id_seq', 3, true);


--
-- Name: filled_bottles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE filled_bottles (
    id integer NOT NULL,
    name text,
    bottle_id integer,
    beverage_id integer
);


ALTER TABLE public.filled_bottles OWNER TO postgres;

--
-- Name: filled_bottles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE filled_bottles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.filled_bottles_id_seq OWNER TO postgres;

--
-- Name: filled_bottles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE filled_bottles_id_seq OWNED BY filled_bottles.id;


--
-- Name: filled_bottles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('filled_bottles_id_seq', 5, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE beverages ALTER COLUMN id SET DEFAULT nextval('beverages_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE bottles ALTER COLUMN id SET DEFAULT nextval('bottles_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE filled_bottles ALTER COLUMN id SET DEFAULT nextval('filled_bottles_id_seq'::regclass);


--
-- Data for Name: beverages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY beverages (id, name, description) FROM stdin;
1	сидр	отличный русский напиток
4	квас	ещё один отличный русский напиток
5	кофе	во мне уже три двойных эспрессо. \r\nupd.: ещё одно, но готово редактирование
2	cola	отличный нерусский напиток
3	чай	безалкогольный напиток (отредактировано)
16	тоник	Не дай себе засохнуть 2
21	лимонад	Просто добавь воды
19	сок	Не очень \\" 2\r\n
22	бражка	floppy
\.


--
-- Data for Name: bottles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY bottles (id, name, description, img_src) FROM stdin;
2	широкая	очень широкая бутылка	wide.png
3	квадратная	обыкновенная квадратная бутылка	square.png
1	узкая	высокая узкая бутылка	tall.png
\.


--
-- Data for Name: filled_bottles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY filled_bottles (id, name, bottle_id, beverage_id) FROM stdin;
1	специально для ненасти	2	4
2	ещё одна полная бутылка	3	19
3	тетя груша	\N	\N
5	Эспрессо	1	5
\.


--
-- Name: beverages_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY beverages
    ADD CONSTRAINT beverages_name_key UNIQUE (name);


--
-- Name: beverages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY beverages
    ADD CONSTRAINT beverages_pkey PRIMARY KEY (id);


--
-- Name: bottles_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bottles
    ADD CONSTRAINT bottles_name_key UNIQUE (name);


--
-- Name: bottles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bottles
    ADD CONSTRAINT bottles_pkey PRIMARY KEY (id);


--
-- Name: filled_bottles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY filled_bottles
    ADD CONSTRAINT filled_bottles_pkey PRIMARY KEY (id);


--
-- Name: filled_bottles_beverage_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY filled_bottles
    ADD CONSTRAINT filled_bottles_beverage_id_fkey FOREIGN KEY (beverage_id) REFERENCES beverages(id) ON DELETE CASCADE;


--
-- Name: filled_bottles_bottle_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY filled_bottles
    ADD CONSTRAINT filled_bottles_bottle_id_fkey FOREIGN KEY (bottle_id) REFERENCES bottles(id) ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

