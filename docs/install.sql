--
-- PostgreSQL database dump
--

-- Started on 2010-04-09 01:22:43 MSD

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
-- TOC entry 1501 (class 1259 OID 16437)
-- Dependencies: 3
-- Name: beverages; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE beverages (
    id integer NOT NULL,
    name text,
    description text
);


--
-- TOC entry 1500 (class 1259 OID 16435)
-- Dependencies: 1501 3
-- Name: beverages_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE beverages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 1805 (class 0 OID 0)
-- Dependencies: 1500
-- Name: beverages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE beverages_id_seq OWNED BY beverages.id;


--
-- TOC entry 1806 (class 0 OID 0)
-- Dependencies: 1500
-- Name: beverages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('beverages_id_seq', 34, true);


--
-- TOC entry 1503 (class 1259 OID 16450)
-- Dependencies: 3
-- Name: bottles; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE bottles (
    id integer NOT NULL,
    name text,
    description text,
    img_src text
);


--
-- TOC entry 1502 (class 1259 OID 16448)
-- Dependencies: 1503 3
-- Name: bottles_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE bottles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 1807 (class 0 OID 0)
-- Dependencies: 1502
-- Name: bottles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE bottles_id_seq OWNED BY bottles.id;


--
-- TOC entry 1808 (class 0 OID 0)
-- Dependencies: 1502
-- Name: bottles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('bottles_id_seq', 3, true);


--
-- TOC entry 1505 (class 1259 OID 16485)
-- Dependencies: 3
-- Name: filled_bottles; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE filled_bottles (
    id integer NOT NULL,
    name text,
    bottle_id integer,
    beverage_id integer
);


--
-- TOC entry 1504 (class 1259 OID 16483)
-- Dependencies: 3 1505
-- Name: filled_bottles_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE filled_bottles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- TOC entry 1809 (class 0 OID 0)
-- Dependencies: 1504
-- Name: filled_bottles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE filled_bottles_id_seq OWNED BY filled_bottles.id;


--
-- TOC entry 1810 (class 0 OID 0)
-- Dependencies: 1504
-- Name: filled_bottles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('filled_bottles_id_seq', 10, true);


--
-- TOC entry 1783 (class 2604 OID 16440)
-- Dependencies: 1501 1500 1501
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE beverages ALTER COLUMN id SET DEFAULT nextval('beverages_id_seq'::regclass);


--
-- TOC entry 1784 (class 2604 OID 16453)
-- Dependencies: 1502 1503 1503
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE bottles ALTER COLUMN id SET DEFAULT nextval('bottles_id_seq'::regclass);


--
-- TOC entry 1785 (class 2604 OID 16488)
-- Dependencies: 1504 1505 1505
-- Name: id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE filled_bottles ALTER COLUMN id SET DEFAULT nextval('filled_bottles_id_seq'::regclass);


--
-- TOC entry 1798 (class 0 OID 16437)
-- Dependencies: 1501
-- Data for Name: beverages; Type: TABLE DATA; Schema: public; Owner: -
--

COPY beverages (id, name, description) FROM stdin;
21	Лимонад	Сладкий безалкогольный напиток, чаще газированный. Обладает прохладительным свойством. Приготавливается исключительно из плодов лимона. Хотя многие заблуждаются, называя любой прохладительный напиток лимонадом.
19	Сидр	Cлабоалкогольный напиток, как правило шампанизированный, получаемый путем сбраживания яблочного сока без добавления дрожжей.
3	Чай	Напиток, получаемый варкой, завариванием или настаиванием листа чайного куста, который предварительно подготавливается специальным образом. Чаем также называется сам лист, предназначенный для приготовления этого напитка.
34	Вино	Алкогольный напиток (крепость: натуральных — 9–16 % об., креплёных — 16–22 % об.), получаемый полным или частичным спиртовым брожением виноградного или плодово-ягодного сока (иногда с добавлением спирта и других веществ — т. н. «креплёное вино»).
16	Тоник	Горько-кислый газированный напиток с содержанием хинина. Часто используется для разбавления спиртных напитков, особенно джина, приготовления коктейлей.\r\nНапиток был изобретен для борьбы с малярией в Индии и Африке. В одно время солдаты Британской Ост-Индской компании смешали тоник с джином, чтобы забить резкий вкус хинина, так появился поныне популярный коктейль Джин-тоник.
29	Кофе	Напиток, изготавливаемый из жареных зёрен кофейного дерева. Благодаря содержанию кофеина оказывает стимулирующее действие.
2	Квас	Национальный слабоалкогольный напиток с объёмной долей этилового спирта не более 1,2%, изготовленный в результате незавершённого спиртового или спиртового и молочнокислого брожения сусла. Обладает приятным, освежающим вкусом, полезен для пищеварения, улучшает обмен веществ, благотворно влияет на сердечно-сосудистую систему.
\.


--
-- TOC entry 1799 (class 0 OID 16450)
-- Dependencies: 1503
-- Data for Name: bottles; Type: TABLE DATA; Schema: public; Owner: -
--

COPY bottles (id, name, description, img_src) FROM stdin;
2	широкая	очень широкая бутылка	wide.png
3	квадратная	обыкновенная квадратная бутылка	square.png
1	узкая	высокая узкая бутылка	tall.png
\.


--
-- TOC entry 1800 (class 0 OID 16485)
-- Dependencies: 1505
-- Data for Name: filled_bottles; Type: TABLE DATA; Schema: public; Owner: -
--

COPY filled_bottles (id, name, bottle_id, beverage_id) FROM stdin;
2	ещё одна полная бутылка	3	19
3	тетя груша	\N	\N
6	nestea	2	3
7	sprite	1	16
8	coca-cola	3	2
9	тётя груша	1	21
10	Эспрессо	3	29
\.


--
-- TOC entry 1787 (class 2606 OID 16447)
-- Dependencies: 1501 1501
-- Name: beverages_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY beverages
    ADD CONSTRAINT beverages_name_key UNIQUE (name);


--
-- TOC entry 1789 (class 2606 OID 16445)
-- Dependencies: 1501 1501
-- Name: beverages_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY beverages
    ADD CONSTRAINT beverages_pkey PRIMARY KEY (id);


--
-- TOC entry 1791 (class 2606 OID 16460)
-- Dependencies: 1503 1503
-- Name: bottles_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY bottles
    ADD CONSTRAINT bottles_name_key UNIQUE (name);


--
-- TOC entry 1793 (class 2606 OID 16458)
-- Dependencies: 1503 1503
-- Name: bottles_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY bottles
    ADD CONSTRAINT bottles_pkey PRIMARY KEY (id);


--
-- TOC entry 1795 (class 2606 OID 16493)
-- Dependencies: 1505 1505
-- Name: filled_bottles_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY filled_bottles
    ADD CONSTRAINT filled_bottles_pkey PRIMARY KEY (id);


--
-- TOC entry 1797 (class 2606 OID 16499)
-- Dependencies: 1788 1505 1501
-- Name: filled_bottles_beverage_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY filled_bottles
    ADD CONSTRAINT filled_bottles_beverage_id_fkey FOREIGN KEY (beverage_id) REFERENCES beverages(id) ON DELETE CASCADE;


--
-- TOC entry 1796 (class 2606 OID 16494)
-- Dependencies: 1505 1503 1792
-- Name: filled_bottles_bottle_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY filled_bottles
    ADD CONSTRAINT filled_bottles_bottle_id_fkey FOREIGN KEY (bottle_id) REFERENCES bottles(id) ON DELETE CASCADE;


--
-- TOC entry 1804 (class 0 OID 0)
-- Dependencies: 3
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2010-04-09 01:22:43 MSD

--
-- PostgreSQL database dump complete
--

