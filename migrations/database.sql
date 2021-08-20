--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2
-- Dumped by pg_dump version 12.2

-- Started on 2020-07-08 12:23:55

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 16504)
-- Name: pg_trgm; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pg_trgm WITH SCHEMA public;


--
-- TOC entry 3047 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION pg_trgm; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION pg_trgm IS 'text similarity measurement and index searching based on trigrams';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 203 (class 1259 OID 16471)
-- Name: asset; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.asset (
    serial character varying(255),
    active boolean,
    asset_name character varying(255),
    type character varying(255),
    out_of_order boolean,
    text character varying(2000),
    created timestamp without time zone DEFAULT now() NOT NULL,
    updated timestamp without time zone,
    id bigint NOT NULL,
    teamviewer_id character varying,
    is_loan boolean DEFAULT false NOT NULL,
    citrix bigint,
    dhcp boolean,
    ip character varying(255),
    subnet character varying(255),
    dns1 character varying(255),
    dns2 character varying(255),
    gateway character varying(255)
);


ALTER TABLE public.asset OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16627)
-- Name: asset_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.asset_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.asset_id_seq OWNER TO postgres;

--
-- TOC entry 3048 (class 0 OID 0)
-- Dependencies: 210
-- Name: asset_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.asset_id_seq OWNED BY public.asset.id;


--
-- TOC entry 204 (class 1259 OID 16474)
-- Name: asset_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.asset_user (
    id bigint NOT NULL,
    person bigint NOT NULL,
    email character varying(500) NOT NULL,
    password character varying(255) NOT NULL,
    password_reset_hash character varying(255),
    password_reset_date timestamp with time zone,
    last_login timestamp with time zone,
    deactivated boolean,
    created timestamp with time zone DEFAULT now() NOT NULL,
    updated timestamp with time zone,
    api_token character varying(255),
    api_token_valid_until timestamp with time zone,
    is_admin boolean DEFAULT false NOT NULL,
    nickname character varying,
    per_page_preference integer
);


ALTER TABLE public.asset_user OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 16818)
-- Name: citrix; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.citrix (
    id bigint NOT NULL,
    citrix_number character varying,
    password character varying,
    created timestamp with time zone DEFAULT now() NOT NULL,
    updated timestamp with time zone,
    show_id character varying
);


ALTER TABLE public.citrix OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16816)
-- Name: citrix_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.citrix_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.citrix_id_seq OWNER TO postgres;

--
-- TOC entry 3049 (class 0 OID 0)
-- Dependencies: 215
-- Name: citrix_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.citrix_id_seq OWNED BY public.citrix.id;


--
-- TOC entry 208 (class 1259 OID 16486)
-- Name: enduser; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.enduser (
    id bigint NOT NULL,
    person bigint,
    place bigint,
    active boolean,
    text text,
    tel character varying(255),
    mobile character varying(255),
    email character varying(255),
    created timestamp with time zone DEFAULT now() NOT NULL,
    updated timestamp with time zone
);


ALTER TABLE public.enduser OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 16653)
-- Name: enduser_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.enduser_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.enduser_id_seq OWNER TO postgres;

--
-- TOC entry 3050 (class 0 OID 0)
-- Dependencies: 212
-- Name: enduser_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.enduser_id_seq OWNED BY public.asset_user.id;


--
-- TOC entry 213 (class 1259 OID 16669)
-- Name: enduser_id_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.enduser_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.enduser_id_seq1 OWNER TO postgres;

--
-- TOC entry 3051 (class 0 OID 0)
-- Dependencies: 213
-- Name: enduser_id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.enduser_id_seq1 OWNED BY public.enduser.id;


--
-- TOC entry 205 (class 1259 OID 16477)
-- Name: person; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.person (
    id bigint NOT NULL,
    last_name character varying(255),
    first_name character varying(255),
    created timestamp with time zone DEFAULT now(),
    updated timestamp with time zone
);


ALTER TABLE public.person OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 16642)
-- Name: person_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.person_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.person_id_seq OWNER TO postgres;

--
-- TOC entry 3052 (class 0 OID 0)
-- Dependencies: 211
-- Name: person_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.person_id_seq OWNED BY public.person.id;


--
-- TOC entry 206 (class 1259 OID 16480)
-- Name: place; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.place (
    longitude character varying(255),
    latitude character varying(255),
    street character varying(255),
    number character varying(255),
    postcode character varying(255),
    city character varying(255),
    tel1 character varying(255),
    tel2 character varying(255),
    tel3 character varying(255),
    tel4 character varying(255),
    fax character varying(255),
    opening_times character varying(2000),
    website character varying(255),
    email character varying(255),
    last_changed timestamp without time zone,
    created timestamp without time zone DEFAULT now() NOT NULL,
    updated timestamp without time zone,
    text character varying(2000),
    active boolean DEFAULT true NOT NULL,
    name character varying(255),
    id bigint NOT NULL,
    citrix bigint,
    is_vvk boolean
);


ALTER TABLE public.place OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16851)
-- Name: place_citrix; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.place_citrix (
    id bigint NOT NULL,
    citrix integer NOT NULL,
    place integer NOT NULL
);


ALTER TABLE public.place_citrix OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 16847)
-- Name: place_citrix_citrix_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.place_citrix_citrix_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_citrix_citrix_seq OWNER TO postgres;

--
-- TOC entry 3053 (class 0 OID 0)
-- Dependencies: 218
-- Name: place_citrix_citrix_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_citrix_citrix_seq OWNED BY public.place_citrix.citrix;


--
-- TOC entry 217 (class 1259 OID 16845)
-- Name: place_citrix_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.place_citrix_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_citrix_id_seq OWNER TO postgres;

--
-- TOC entry 3054 (class 0 OID 0)
-- Dependencies: 217
-- Name: place_citrix_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_citrix_id_seq OWNED BY public.place_citrix.id;


--
-- TOC entry 219 (class 1259 OID 16849)
-- Name: place_citrix_place_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.place_citrix_place_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_citrix_place_seq OWNER TO postgres;

--
-- TOC entry 3055 (class 0 OID 0)
-- Dependencies: 219
-- Name: place_citrix_place_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_citrix_place_seq OWNED BY public.place_citrix.place;


--
-- TOC entry 209 (class 1259 OID 16604)
-- Name: place_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.place_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.place_id_seq OWNER TO postgres;

--
-- TOC entry 3056 (class 0 OID 0)
-- Dependencies: 209
-- Name: place_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_id_seq OWNED BY public.place.id;


--
-- TOC entry 207 (class 1259 OID 16483)
-- Name: places_assets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.places_assets (
    id bigint NOT NULL,
    place bigint NOT NULL,
    asset bigint NOT NULL,
    deliverer_person bigint,
    receiver_person bigint,
    delivery_datetimez timestamp with time zone,
    from_datetimez timestamp with time zone,
    until_datetimez timestamp with time zone,
    pickup_datetimez timestamp with time zone,
    pickup_person_id bigint,
    pickup_responsible_person_id bigint,
    automatic_callback boolean,
    text text,
    created timestamp with time zone DEFAULT now() NOT NULL,
    updated timestamp with time zone,
    delivered boolean DEFAULT false NOT NULL
);


ALTER TABLE public.places_assets OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 16710)
-- Name: places_assets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.places_assets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.places_assets_id_seq OWNER TO postgres;

--
-- TOC entry 3057 (class 0 OID 0)
-- Dependencies: 214
-- Name: places_assets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.places_assets_id_seq OWNED BY public.places_assets.id;


--
-- TOC entry 2789 (class 2604 OID 16629)
-- Name: asset id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset ALTER COLUMN id SET DEFAULT nextval('public.asset_id_seq'::regclass);


--
-- TOC entry 2791 (class 2604 OID 16655)
-- Name: asset_user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user ALTER COLUMN id SET DEFAULT nextval('public.enduser_id_seq'::regclass);


--
-- TOC entry 2804 (class 2604 OID 16821)
-- Name: citrix id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citrix ALTER COLUMN id SET DEFAULT nextval('public.citrix_id_seq'::regclass);


--
-- TOC entry 2802 (class 2604 OID 16671)
-- Name: enduser id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser ALTER COLUMN id SET DEFAULT nextval('public.enduser_id_seq1'::regclass);


--
-- TOC entry 2794 (class 2604 OID 16644)
-- Name: person id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.person ALTER COLUMN id SET DEFAULT nextval('public.person_id_seq'::regclass);


--
-- TOC entry 2798 (class 2604 OID 16606)
-- Name: place id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place ALTER COLUMN id SET DEFAULT nextval('public.place_id_seq'::regclass);


--
-- TOC entry 2806 (class 2604 OID 16854)
-- Name: place_citrix id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix ALTER COLUMN id SET DEFAULT nextval('public.place_citrix_id_seq'::regclass);


--
-- TOC entry 2807 (class 2604 OID 16855)
-- Name: place_citrix citrix; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix ALTER COLUMN citrix SET DEFAULT nextval('public.place_citrix_citrix_seq'::regclass);


--
-- TOC entry 2808 (class 2604 OID 16856)
-- Name: place_citrix place; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix ALTER COLUMN place SET DEFAULT nextval('public.place_citrix_place_seq'::regclass);


--
-- TOC entry 2799 (class 2604 OID 16712)
-- Name: places_assets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets ALTER COLUMN id SET DEFAULT nextval('public.places_assets_id_seq'::regclass);


--
-- TOC entry 3024 (class 0 OID 16471)
-- Dependencies: 203
-- Data for Name: asset; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.asset (serial, active, asset_name, type, out_of_order, text, created, updated, id, teamviewer_id, is_loan, citrix) FROM stdin;
Test_serial	t	Test_name	Test_type	f	test_text	2020-03-23 23:21:55.903525	\N	1	\N	f	\N
\N	\N	\N	\N	\N	\N	2020-06-25 20:27:15.856819	\N	173	\N	f	\N
test2	\N	\N	\N	\N	\N	2020-03-30 21:51:05.956264	2020-03-30 22:31:50.422355	2	\N	f	\N
dgfd	f	zutu	dgf	t	dgfdgf	2020-05-06 02:59:11.377009	\N	121	\N	f	\N
seria1	t	test1	Bildschirm	\N	aglkdsjflkdsjf\nsalkfjsldfj	2020-06-05 10:52:13.07449	\N	138	\N	f	\N
1234	t	Rere	Fernseher	f		2020-06-24 00:25:34.692648	\N	139	\N	f	\N
	t	safs	asds	f		2020-06-24 00:57:10.440847	\N	140	\N	f	\N
asfdsf	t	asgasdf	asfsdf	f	asdaaa	2020-06-24 00:58:31.781781	\N	141	\N	f	\N
asgdf	t	agsdf	asdfs	f		2020-06-24 01:00:15.924253	\N	142	\N	f	\N
adsd	t	asdfs	asda	f		2020-06-24 01:02:08.490982	\N	143	\N	f	\N
asf	t	asfsdf	sfasdf	f		2020-06-24 01:39:49.966845	\N	144	\N	f	\N
wwe	t	wwqqq	wwrasa	f	dgdsgfd	2020-05-06 02:58:29.821219	2020-06-25 18:53:29.378673	120	\N	f	\N
asdfdsaf	t	asfdsf	sagfdsaf	f	asdfdsaf	2020-06-25 18:53:51.73077	\N	145	\N	f	\N
asdfdsafaaa	t	safadsf	asfsadf	f	aaa	2020-06-25 22:34:11.126682	\N	209	asfsdf	f	\N
sadsaf	t	aasfsf	safsdss	f		2020-06-25 22:38:40.620157	\N	210	asdfs	f	\N
\N	\N	\N	\N	\N	\N	2020-06-25 18:54:43.878254	\N	150	\N	f	\N
\N	\N	\N	\N	\N	\N	2020-06-25 18:54:50.640683	\N	151	\N	f	\N
qwtwrwqer	t	asdfdsa	asdfasdf	f	afsdf	2020-06-25 22:39:50.09645	\N	211	qwreweqr	f	\N
asdfds	t	asdfag	asdfdsaf	f	asdfdsaf	2020-06-25 22:41:32.753599	\N	212	asdfsdaf	f	\N
asdfdsafsd	t	asdfdsaf	asdfsdafsaa	f	asdfdsafdsaf	2020-06-25 22:43:12.077239	\N	215	asdfsadf	f	\N
q	t	dfasdfs	asdfdsf	f	asdfdsf	2020-06-25 22:43:40.292431	\N	216	s	f	\N
\N	t	asdfsdf	sadfdsf	\N	\N	2020-06-26 12:04:24.068817	\N	217	\N	f	\N
\N	t	asdfdsaf	sdfsdaf	\N	\N	2020-06-26 12:04:36.195336	\N	218	\N	f	\N
sadfdsaf	t	fasdfsdaf	asdfdsf	f	sadfdsfa	2020-06-25 18:55:32.382248	\N	160	\N	f	\N
sadfdsafasdf	t	fasdfsdaf	asdfdsf	f	sadfdsfa	2020-06-25 18:55:39.955776	\N	161	\N	f	\N
\N	\N	\N	\N	\N	\N	2020-07-05 23:10:26.962372	\N	219	\N	f	\N
codecept_serial	t	codecept_name	codecept_type	\N	codecept_text	2020-07-05 23:10:27.072076	\N	220	\N	f	\N
\N	\N	\N	\N	\N	\N	2020-07-05 23:15:06.303969	\N	221	\N	f	\N
sfasdf	t	asfdf	asdfgasdf	f	asfsdaf	2020-06-25 19:09:00.31977	\N	166	\N	f	\N
asdfsdf	t	asdfsda	asfsdaf	f	asdfdsf	2020-06-25 19:16:50.934426	\N	167	\N	f	\N
test1234	t	test	rer	f	sadfsa	2020-06-25 20:23:21.60417	\N	168	\N	f	\N
\N	\N	\N	\N	\N	\N	2020-07-05 23:17:09.216817	\N	223	\N	f	\N
\N	\N	\N	\N	\N	\N	2020-07-05 23:25:53.229432	\N	225	\N	f	\N
Ist	t	Dies	test	\N	sdfsd	2020-07-06 04:40:27.578997	\N	227	ein	f	1
ikst	t	Dies	test	\N	sdfsd	2020-07-06 04:41:06.025005	\N	230	eing	f	1
asdf	t	Dasdf	sadfdsf	\N	safsdf	2020-07-06 04:43:15.870089	\N	232	asdfs2121	f	3
123189	t	sadf	Fernseher	\N	\N	2020-07-06 04:47:50.252664	\N	233	\N	f	\N
\N	t	gerwer	Fernseher	\N	\N	2020-07-06 04:57:09.117241	\N	234	\N	f	\N
\N	t	asdfsdfaaaa1	Fernseher	\N	\N	2020-07-06 05:01:06.30626	\N	236	\N	f	\N
\N	t	gerwera	Fernseher	\N	\N	2020-07-06 05:04:34.160171	\N	237	\N	f	\N
\N	t	erewr	Fernseher	\N	\N	2020-07-06 05:09:19.471962	\N	238	\N	f	1
\.


--
-- TOC entry 3025 (class 0 OID 16474)
-- Dependencies: 204
-- Data for Name: asset_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.asset_user (id, person, email, password, password_reset_hash, password_reset_date, last_login, deactivated, created, updated, api_token, api_token_valid_until, is_admin, nickname) FROM stdin;
8	6	email_test@example.com	$2y$10$1aPvZDIbCLPtmRw44fdUz.bWfYowBBLjDOZfHKEEnVXjVVIXIi2Vu	\N	\N	2020-07-08 09:42:28.283836+02	f	2020-05-01 00:34:52.710516+02	\N	5bb8d0b940d2f791163580b2fc8eb20c2346b3269bd19ce7ce2386c543f82aa6	2020-07-08 10:42:28.283836+02	f	\N
\.


--
-- TOC entry 3037 (class 0 OID 16818)
-- Dependencies: 216
-- Data for Name: citrix; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.citrix (id, citrix_number, password, created, updated, show_id) FROM stdin;
1	test123	asdf	2020-07-06 03:58:27.792935+02	\N	sf
3	test1233	sadf	2020-07-06 03:59:19.221486+02	\N	asdf
\.


--
-- TOC entry 3029 (class 0 OID 16486)
-- Dependencies: 208
-- Data for Name: enduser; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.enduser (id, person, place, active, text, tel, mobile, email, created, updated) FROM stdin;
16	6	\N	f	\N	\N	\N	\N	2020-05-02 19:05:28.986231+02	\N
61	109	1	t	asfs	asd	asd	asd	2020-06-26 02:25:52.619556+02	2020-06-26 02:40:48.425732+02
62	6	\N	f	\N	\N	\N	\N	2020-07-05 23:17:13.932946+02	\N
63	6	\N	f	\N	\N	\N	\N	2020-07-05 23:25:57.852897+02	\N
\.


--
-- TOC entry 3026 (class 0 OID 16477)
-- Dependencies: 205
-- Data for Name: person; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.person (id, last_name, first_name, created, updated) FROM stdin;
7	test1	test	2020-04-25 10:24:52.282693+02	\N
6	test5	test2	2020-04-25 10:24:51.441662+02	2020-04-25 10:28:41.574101+02
107	nachname	vorname	2020-06-26 02:22:29.349235+02	\N
108	nachname	vorname	2020-06-26 02:25:03.63298+02	\N
109	Nachnamea	Vornamea	2020-06-26 02:25:52.236263+02	2020-06-26 02:40:48.331221+02
\.


--
-- TOC entry 3027 (class 0 OID 16480)
-- Dependencies: 206
-- Data for Name: place; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.place (longitude, latitude, street, number, postcode, city, tel1, tel2, tel3, tel4, fax, opening_times, website, email, created, updated, text, active, name, id, citrix) FROM stdin;
test_longitude	test_latitude	test_street	test_number	test_postcode	test_city	test_te1	test_tel2	test_tel3	test_tel4	test_fax	test_ot	test_website	test_email	2020-03-23 23:37:03.901873	\N	test_text	t	test_name	1	\N
\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2020-04-03 19:57:04.979528	\N	\N	t	test2	3	\N
\N	\N	safsdf	a	asdf	asdsad									2020-06-25 23:32:54.177735	\N		t	aasdfdsf	111	\N
\N	\N	Lerchenstr.	3	73249	Wernau						1 jkj\n2 ljkl\n3 lkjl			2020-06-25 23:27:16.74642	2020-06-25 23:34:43.279038		t	Test1	110	\N
\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2020-07-05 22:57:36.91875	\N	\N	t	\N	112	\N
codecept_longitude	codecept_latitude	codecept_street	codecept_number	codecept_postcode	codecept_city	codecept_tel1	codecept_tel2	codecept_tel3	codecept_tel4	codecept_fax	codecept_opening_times	codecept_website	codecept_email	2020-07-05 22:57:37.032735	\N	codecept_text	t	codecept_name	113	\N
\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2020-07-05 23:10:27.841787	\N	\N	t	\N	114	\N
codecept_longitude	codecept_latitude	codecept_street	codecept_number	codecept_postcode	codecept_city	codecept_tel1	codecept_tel2	codecept_tel3	codecept_tel4	codecept_fax	codecept_opening_times	codecept_website	codecept_email	2020-07-05 23:10:27.979135	\N	codecept_text	t	codecept_name	115	\N
\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2020-07-05 23:15:07.161496	\N	\N	t	\N	116	\N
codecept_longitude	codecept_latitude	codecept_street	codecept_number	codecept_postcode	codecept_city	codecept_tel1	codecept_tel2	codecept_tel3	codecept_tel4	codecept_fax	codecept_opening_times	codecept_website	codecept_email	2020-07-05 23:15:07.258984	\N	codecept_text	t	codecept_name	117	\N
\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2020-07-05 23:17:10.17678	\N	\N	t	\N	118	\N
codecept_longitude	codecept_latitude	codecept_street	codecept_number	codecept_postcode	codecept_city	codecept_tel1	codecept_tel2	codecept_tel3	codecept_tel4	codecept_fax	codecept_opening_times	codecept_website	codecept_email	2020-07-05 23:17:10.279083	\N	codecept_text	t	codecept_name	119	\N
\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2020-07-05 23:25:54.106278	\N	\N	t	\N	120	\N
codecept_longitude	codecept_latitude	codecept_street	\N	codecept_postcode	codecept_city	codecept_tel1	codecept_tel2	codecept_tel3	codecept_tel4	codecept_fax	codecept_opening_times	codecept_website	codecept_email	2020-07-05 23:25:54.203945	\N	codecept_text	t	codecept_name	121	\N
\N	\N	Strasse	\N	23232	Ort	001	002	003	004	00	zeiten	website	email	2020-07-06 15:25:01.193301	\N	text	t	Name	127	1
\N	\N	strasse2	3	23232	Ort2	0001	0002	0003	0004	0005	zeiten	website	email	2020-07-06 15:33:04.183104	\N	text	t	Name2	128	1
\.


--
-- TOC entry 3041 (class 0 OID 16851)
-- Dependencies: 220
-- Data for Name: place_citrix; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.place_citrix (id, citrix, place) FROM stdin;
\.


--
-- TOC entry 3028 (class 0 OID 16483)
-- Dependencies: 207
-- Data for Name: places_assets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.places_assets (id, place, asset, deliverer_person, receiver_person, delivery_datetimez, from_datetimez, until_datetimez, pickup_datetimez, pickup_person_id, pickup_responsible_person_id, automatic_callback, text, created, updated, delivered) FROM stdin;
32	1	212	8	\N	2020-06-25 22:41:32+02	\N	\N	\N	\N	\N	f	\N	2020-06-25 22:41:33.314135+02	\N	t
33	1	215	8	\N	2020-06-25 22:43:12+02	2020-06-25 22:43:12+02	\N	\N	\N	\N	f	\N	2020-06-25 22:43:12.599246+02	\N	t
34	1	216	8	\N	2020-06-25 22:43:40+02	2020-06-25 22:43:40+02	\N	\N	\N	\N	f	\N	2020-06-25 22:43:40.807845+02	\N	t
36	1	217	8	\N	2020-06-26 12:04:24+02	2020-06-26 12:04:24+02	\N	\N	\N	\N	f	\N	2020-06-26 12:04:24.530887+02	\N	t
37	1	218	8	\N	2020-06-26 12:04:36+02	2020-06-26 12:04:36+02	\N	\N	\N	\N	f	\N	2020-06-26 12:04:36.656772+02	\N	t
42	1	236	8	\N	2020-07-06 05:01:06+02	2020-07-06 05:01:06+02	\N	\N	\N	\N	f	\N	2020-07-06 05:01:06.859859+02	\N	t
43	1	237	8	\N	2020-07-06 05:04:34+02	2020-07-06 05:04:34+02	\N	\N	\N	\N	f	\N	2020-07-06 05:04:34.968832+02	\N	t
44	1	238	8	\N	2020-07-06 05:09:19+02	2020-07-06 05:09:19+02	\N	\N	\N	\N	f	\N	2020-07-06 05:09:20.051285+02	\N	t
45	1	168	8	\N	\N	2020-07-06 07:15:47+02	\N	\N	\N	\N	f	\N	2020-07-06 07:15:47.640664+02	\N	f
47	117	141	8	\N	\N	2020-07-06 07:21:39+02	\N	\N	\N	\N	f	\N	2020-07-06 07:21:39.821295+02	\N	f
1	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	\N	\N	2020-05-03 01:30:48.159876+02	\N	f
5	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-05-03 01:40:30.323348+02	\N	f
24	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-05-26 01:56:08.244038+02	\N	f
25	1	1	6	6	2021-01-01 15:00:00+01	2021-02-01 15:00:00+01	2020-07-07 07:40:34+02	2021-04-01 15:00:00+02	6	6	f	codecept_email@example.com	2020-05-26 01:56:08.598297+02	\N	f
26	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-05-26 01:57:58.652982+02	\N	f
27	1	1	6	6	2021-01-01 15:00:00+01	2021-02-01 15:00:00+01	2020-07-07 07:40:34+02	2021-04-01 15:00:00+02	6	6	f	codecept_email@example.com	2020-05-26 01:57:58.990839+02	\N	f
28	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-05-26 02:30:39.383865+02	\N	f
29	1	1	6	6	2021-01-01 15:00:00+01	2021-02-01 15:00:00+01	2020-07-07 07:40:34+02	2021-04-01 15:00:00+02	6	6	f	codecept_email@example.com	2020-05-26 02:30:39.717613+02	\N	f
30	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-05-26 02:37:17.094323+02	\N	f
31	1	1	6	6	2021-01-01 15:00:00+01	2021-02-01 15:00:00+01	2020-07-07 07:40:34+02	2021-04-01 15:00:00+02	6	6	f	codecept_email@example.com	2020-05-26 02:37:17.433139+02	\N	f
38	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-07-05 23:10:32.565122+02	\N	f
39	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-07-05 23:15:12.210918+02	\N	f
40	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-07-05 23:17:15.273307+02	\N	f
41	1	1	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-07-05 23:25:59.07609+02	\N	f
35	110	138	\N	\N	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-06-26 06:02:26.868962+02	\N	f
46	110	138	8	\N	\N	2020-07-07 07:19:13+02	2020-07-07 07:40:34+02	\N	\N	\N	f	\N	2020-07-06 07:19:13.988418+02	\N	f
48	110	230	8	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	\N	f	\N	2020-07-06 07:40:34.523702+02	\N	f
49	110	138	8	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	\N	f	\N	2020-07-06 07:40:34.607072+02	\N	f
50	110	1	8	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	\N	f	\N	2020-07-06 07:40:34.619255+02	\N	f
51	110	167	8	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	\N	f	\N	2020-07-06 07:40:34.674752+02	\N	f
52	110	210	8	\N	\N	2020-07-07 07:40:34+02	\N	\N	\N	\N	f	\N	2020-07-06 07:40:34.758548+02	\N	f
\.


--
-- TOC entry 3058 (class 0 OID 0)
-- Dependencies: 210
-- Name: asset_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.asset_id_seq', 238, true);


--
-- TOC entry 3059 (class 0 OID 0)
-- Dependencies: 215
-- Name: citrix_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.citrix_id_seq', 3, true);


--
-- TOC entry 3060 (class 0 OID 0)
-- Dependencies: 212
-- Name: enduser_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.enduser_id_seq', 72, true);


--
-- TOC entry 3061 (class 0 OID 0)
-- Dependencies: 213
-- Name: enduser_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.enduser_id_seq1', 63, true);


--
-- TOC entry 3062 (class 0 OID 0)
-- Dependencies: 211
-- Name: person_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.person_id_seq', 119, true);


--
-- TOC entry 3063 (class 0 OID 0)
-- Dependencies: 218
-- Name: place_citrix_citrix_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.place_citrix_citrix_seq', 1, false);


--
-- TOC entry 3064 (class 0 OID 0)
-- Dependencies: 217
-- Name: place_citrix_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.place_citrix_id_seq', 1, false);


--
-- TOC entry 3065 (class 0 OID 0)
-- Dependencies: 219
-- Name: place_citrix_place_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.place_citrix_place_seq', 1, false);


--
-- TOC entry 3066 (class 0 OID 0)
-- Dependencies: 209
-- Name: place_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.place_id_seq', 128, true);


--
-- TOC entry 3067 (class 0 OID 0)
-- Dependencies: 214
-- Name: places_assets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.places_assets_id_seq', 52, true);


--
-- TOC entry 2811 (class 2606 OID 16641)
-- Name: asset asset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT asset_pkey PRIMARY KEY (id);


--
-- TOC entry 2815 (class 2606 OID 16793)
-- Name: asset asset_teamviewer_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT asset_teamviewer_id_unique UNIQUE (teamviewer_id);


--
-- TOC entry 2824 (class 2606 OID 16667)
-- Name: asset_user asset_user_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user
    ADD CONSTRAINT asset_user_email_unique UNIQUE (email);


--
-- TOC entry 2877 (class 2606 OID 16831)
-- Name: citrix citrix_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citrix
    ADD CONSTRAINT citrix_number_unique UNIQUE (citrix_number);


--
-- TOC entry 2879 (class 2606 OID 16826)
-- Name: citrix citrix_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citrix
    ADD CONSTRAINT citrix_pkey PRIMARY KEY (id);


--
-- TOC entry 2829 (class 2606 OID 16663)
-- Name: asset_user enduser_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user
    ADD CONSTRAINT enduser_pkey PRIMARY KEY (id);


--
-- TOC entry 2868 (class 2606 OID 16679)
-- Name: enduser enduser_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser
    ADD CONSTRAINT enduser_pkey1 PRIMARY KEY (id);


--
-- TOC entry 2834 (class 2606 OID 16681)
-- Name: person person_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.person
    ADD CONSTRAINT person_pkey PRIMARY KEY (id);


--
-- TOC entry 2884 (class 2606 OID 16858)
-- Name: place_citrix place_citrix_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix
    ADD CONSTRAINT place_citrix_pkey PRIMARY KEY (id);


--
-- TOC entry 2841 (class 2606 OID 16626)
-- Name: place place_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place
    ADD CONSTRAINT place_pkey PRIMARY KEY (id);


--
-- TOC entry 2861 (class 2606 OID 16720)
-- Name: places_assets places_assets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT places_assets_pkey PRIMARY KEY (id);


--
-- TOC entry 2820 (class 2606 OID 16774)
-- Name: asset serial_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT serial_unique UNIQUE (serial);


--
-- TOC entry 2809 (class 1259 OID 16582)
-- Name: asset_asset_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_asset_name_trgm_gin ON public.asset USING gin (asset_name public.gin_trgm_ops);


--
-- TOC entry 2812 (class 1259 OID 16581)
-- Name: asset_serial_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_serial_trgm_gin ON public.asset USING gin (serial public.gin_trgm_ops);


--
-- TOC entry 2813 (class 1259 OID 16790)
-- Name: asset_teamviewer_id_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_teamviewer_id_trgm_gin ON public.asset USING gin (teamviewer_id public.gin_trgm_ops);


--
-- TOC entry 2816 (class 1259 OID 16584)
-- Name: asset_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_text_trgm_gin ON public.asset USING gin (text public.gin_trgm_ops);


--
-- TOC entry 2817 (class 1259 OID 16583)
-- Name: asset_type_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_type_trgm_gin ON public.asset USING gin (type public.gin_trgm_ops);


--
-- TOC entry 2821 (class 1259 OID 16766)
-- Name: asset_user_api_token; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_api_token ON public.asset_user USING btree (api_token);


--
-- TOC entry 2822 (class 1259 OID 16767)
-- Name: asset_user_api_token_valid; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_api_token_valid ON public.asset_user USING btree (api_token, api_token_valid_until);


--
-- TOC entry 2825 (class 1259 OID 16768)
-- Name: asset_user_password_reset_hash_valid; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_password_reset_hash_valid ON public.asset_user USING btree (password_reset_hash, password_reset_date);


--
-- TOC entry 2826 (class 1259 OID 16769)
-- Name: asset_user_person_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_person_idx ON public.asset_user USING btree (person);


--
-- TOC entry 2875 (class 1259 OID 16827)
-- Name: citrix_number_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX citrix_number_trgm_gin ON public.citrix USING gin (citrix_number public.gin_trgm_ops);


--
-- TOC entry 2880 (class 1259 OID 16828)
-- Name: citrix_show_id_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX citrix_show_id_trgm_gin ON public.citrix USING gin (show_id public.gin_trgm_ops);


--
-- TOC entry 2827 (class 1259 OID 16664)
-- Name: enduser_email_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_email_trgm_gin ON public.asset_user USING gin (email public.gin_trgm_ops);


--
-- TOC entry 2865 (class 1259 OID 16708)
-- Name: enduser_mobile_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_mobile_trgm_gin ON public.enduser USING gin (mobile public.gin_trgm_ops);


--
-- TOC entry 2866 (class 1259 OID 16764)
-- Name: enduser_person_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_person_idx ON public.enduser USING btree (person);


--
-- TOC entry 2869 (class 1259 OID 16765)
-- Name: enduser_place_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_place_idx ON public.enduser USING btree (place);


--
-- TOC entry 2870 (class 1259 OID 16877)
-- Name: enduser_teamviewer_id_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_teamviewer_id_trgm_gin ON public.enduser USING gin (text public.gin_trgm_ops);


--
-- TOC entry 2871 (class 1259 OID 16707)
-- Name: enduser_tel_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_tel_trgm_gin ON public.enduser USING gin (tel public.gin_trgm_ops);


--
-- TOC entry 2872 (class 1259 OID 16709)
-- Name: enduser_user_email_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_user_email_trgm_gin ON public.enduser USING gin (email public.gin_trgm_ops);


--
-- TOC entry 2818 (class 1259 OID 16838)
-- Name: fki_asset_citrix_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_asset_citrix_fk ON public.asset USING btree (citrix);


--
-- TOC entry 2830 (class 1259 OID 16687)
-- Name: fki_asset_user_person; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_asset_user_person ON public.asset_user USING btree (person);


--
-- TOC entry 2873 (class 1259 OID 16698)
-- Name: fki_enduser_person_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_enduser_person_fk ON public.enduser USING btree (person);


--
-- TOC entry 2874 (class 1259 OID 16704)
-- Name: fki_enduser_place_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_enduser_place_fk ON public.enduser USING btree (place);


--
-- TOC entry 2835 (class 1259 OID 16844)
-- Name: fki_person_citrix_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_person_citrix_fk ON public.place USING btree (citrix);


--
-- TOC entry 2881 (class 1259 OID 16864)
-- Name: fki_place_citrix_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_place_citrix_fk ON public.place_citrix USING btree (citrix);


--
-- TOC entry 2882 (class 1259 OID 16876)
-- Name: fki_place_citrix_place_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_place_citrix_place_fk ON public.place_citrix USING btree (place);


--
-- TOC entry 2850 (class 1259 OID 16738)
-- Name: fki_places_assets_asset_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_asset_fk ON public.places_assets USING btree (asset);


--
-- TOC entry 2851 (class 1259 OID 16726)
-- Name: fki_places_assets_deliverer_person_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_deliverer_person_fk ON public.places_assets USING btree (deliverer_person);


--
-- TOC entry 2852 (class 1259 OID 16750)
-- Name: fki_places_assets_pickup_person_id_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_pickup_person_id_fk ON public.places_assets USING btree (pickup_person_id);


--
-- TOC entry 2853 (class 1259 OID 16756)
-- Name: fki_places_assets_pickup_responsible_person_id_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_pickup_responsible_person_id_fk ON public.places_assets USING btree (pickup_responsible_person_id);


--
-- TOC entry 2854 (class 1259 OID 16732)
-- Name: fki_places_assets_place_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_place_fk ON public.places_assets USING btree (place);


--
-- TOC entry 2855 (class 1259 OID 16744)
-- Name: fki_places_assets_receiver_person_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_receiver_person_fk ON public.places_assets USING btree (receiver_person);


--
-- TOC entry 2831 (class 1259 OID 16651)
-- Name: person_first_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX person_first_name_trgm_gin ON public.person USING gin (first_name public.gin_trgm_ops);


--
-- TOC entry 2832 (class 1259 OID 16652)
-- Name: person_last_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX person_last_name_trgm_gin ON public.person USING gin (last_name public.gin_trgm_ops);


--
-- TOC entry 2836 (class 1259 OID 16593)
-- Name: place_city_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_city_trgm_gin ON public.place USING gin (city public.gin_trgm_ops);


--
-- TOC entry 2837 (class 1259 OID 16600)
-- Name: place_email_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_email_trgm_gin ON public.place USING gin (email public.gin_trgm_ops);


--
-- TOC entry 2838 (class 1259 OID 16598)
-- Name: place_fax_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_fax_trgm_gin ON public.place USING gin (fax public.gin_trgm_ops);


--
-- TOC entry 2839 (class 1259 OID 16603)
-- Name: place_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_name_trgm_gin ON public.place USING gin (name public.gin_trgm_ops);


--
-- TOC entry 2842 (class 1259 OID 16592)
-- Name: place_postcode_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_postcode_trgm_gin ON public.place USING gin (postcode public.gin_trgm_ops);


--
-- TOC entry 2843 (class 1259 OID 16591)
-- Name: place_street_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_street_trgm_gin ON public.place USING gin (street public.gin_trgm_ops);


--
-- TOC entry 2844 (class 1259 OID 16594)
-- Name: place_tel1_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel1_trgm_gin ON public.place USING gin (tel1 public.gin_trgm_ops);


--
-- TOC entry 2845 (class 1259 OID 16595)
-- Name: place_tel2_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel2_trgm_gin ON public.place USING gin (tel2 public.gin_trgm_ops);


--
-- TOC entry 2846 (class 1259 OID 16596)
-- Name: place_tel3_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel3_trgm_gin ON public.place USING gin (tel3 public.gin_trgm_ops);


--
-- TOC entry 2847 (class 1259 OID 16597)
-- Name: place_tel4_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel4_trgm_gin ON public.place USING gin (tel4 public.gin_trgm_ops);


--
-- TOC entry 2848 (class 1259 OID 16601)
-- Name: place_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_text_trgm_gin ON public.place USING gin (text public.gin_trgm_ops);


--
-- TOC entry 2849 (class 1259 OID 16599)
-- Name: place_website_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_website_trgm_gin ON public.place USING gin (website public.gin_trgm_ops);


--
-- TOC entry 2856 (class 1259 OID 16758)
-- Name: places_assets_asset_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_asset_idx ON public.places_assets USING btree (asset);


--
-- TOC entry 2857 (class 1259 OID 16759)
-- Name: places_assets_delivery_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_delivery_datetimez_idx ON public.places_assets USING btree (delivery_datetimez);


--
-- TOC entry 2858 (class 1259 OID 16760)
-- Name: places_assets_from_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_from_datetimez_idx ON public.places_assets USING btree (from_datetimez);


--
-- TOC entry 2859 (class 1259 OID 16762)
-- Name: places_assets_pickup_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_pickup_datetimez_idx ON public.places_assets USING btree (pickup_datetimez);


--
-- TOC entry 2862 (class 1259 OID 16757)
-- Name: places_assets_place_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_place_idx ON public.places_assets USING btree (place);


--
-- TOC entry 2863 (class 1259 OID 16763)
-- Name: places_assets_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_text_trgm_gin ON public.places_assets USING gin (text public.gin_trgm_ops);


--
-- TOC entry 2864 (class 1259 OID 16761)
-- Name: places_assets_until_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_until_datetimez_idx ON public.places_assets USING btree (until_datetimez);

CREATE INDEX place_groupy_by_idx ON public.place USING btree (id, name, longitude, latitude, street, number, postcode, city, tel1, tel2, tel3, tel4, fax, opening_times, website, email, text, active);


--
-- TOC entry 2885 (class 2606 OID 16833)
-- Name: asset asset_citrix_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT asset_citrix_fk FOREIGN KEY (citrix) REFERENCES public.citrix(id) NOT VALID;


--
-- TOC entry 2886 (class 2606 OID 16688)
-- Name: asset_user asset_user_person; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user
    ADD CONSTRAINT asset_user_person FOREIGN KEY (person) REFERENCES public.person(id) NOT VALID;


--
-- TOC entry 2890 (class 2606 OID 16796)
-- Name: places_assets deliverer_person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT deliverer_person_user_fk FOREIGN KEY (deliverer_person) REFERENCES public.asset_user(id) NOT VALID;


--
-- TOC entry 2894 (class 2606 OID 16693)
-- Name: enduser enduser_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser
    ADD CONSTRAINT enduser_person_fk FOREIGN KEY (person) REFERENCES public.person(id) NOT VALID;


--
-- TOC entry 2895 (class 2606 OID 16699)
-- Name: enduser enduser_place_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser
    ADD CONSTRAINT enduser_place_fk FOREIGN KEY (place) REFERENCES public.place(id) NOT VALID;


--
-- TOC entry 2887 (class 2606 OID 16839)
-- Name: place person_citrix_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place
    ADD CONSTRAINT place_citrix_fk FOREIGN KEY (citrix) REFERENCES public.place_citrix(citrix) NOT VALID;


--
-- TOC entry 2892 (class 2606 OID 16806)
-- Name: places_assets pickup_person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT pickup_person_user_fk FOREIGN KEY (pickup_person_id) REFERENCES public.asset_user(id) NOT VALID;


--
-- TOC entry 2893 (class 2606 OID 16811)
-- Name: places_assets pickup_responsible_user_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT pickup_responsible_user_id_fk FOREIGN KEY (pickup_responsible_person_id) REFERENCES public.asset_user(id) NOT VALID;


--
-- TOC entry 2896 (class 2606 OID 16866)
-- Name: place_citrix place_citrix_citrix_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix
    ADD CONSTRAINT place_citrix_citrix_fk FOREIGN KEY (citrix) REFERENCES public.citrix(id) NOT VALID;


--
-- TOC entry 2897 (class 2606 OID 16871)
-- Name: place_citrix place_citrix_place_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix
    ADD CONSTRAINT place_citrix_place_fk FOREIGN KEY (place) REFERENCES public.place(id) NOT VALID;


--
-- TOC entry 2889 (class 2606 OID 16733)
-- Name: places_assets places_assets_asset_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT places_assets_asset_fk FOREIGN KEY (asset) REFERENCES public.asset(id) NOT VALID;


--
-- TOC entry 2888 (class 2606 OID 16727)
-- Name: places_assets places_assets_place_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT places_assets_place_fk FOREIGN KEY (place) REFERENCES public.place(id) NOT VALID;


--
-- TOC entry 2891 (class 2606 OID 16801)
-- Name: places_assets receiver_person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT receiver_person_user_fk FOREIGN KEY (receiver_person) REFERENCES public.asset_user(id) NOT VALID;


-- Completed on 2020-07-08 12:23:56

--
-- PostgreSQL database dump complete
--

