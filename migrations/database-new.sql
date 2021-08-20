--
-- PostgreSQL database dump
--

-- Dumped from database version 12.3 (Debian 12.3-1.pgdg100+1)
-- Dumped by pg_dump version 12.3 (Debian 12.3-1.pgdg100+1)

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
-- Name: pg_trgm; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pg_trgm WITH SCHEMA public;


--
-- Name: EXTENSION pg_trgm; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pg_trgm IS 'text similarity measurement and index searching based on trigrams';


--
-- Name: asset_list_view_asset_citrix_change_trigger(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.asset_list_view_asset_citrix_change_trigger() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO asset_list_table (
	  id,
	  serial,
	  active,
	  name,
	  type,
	  out_of_order,
	  is_loan,
	  text,
	  teamviewer_string,
	  dhcp,
	  ip,
	  subnet,
	  dns1,
	  dns2,
	  gateway,
	  place_id,
	  place_name, 
	  city, 
	  street, 
	  number, 
	  citrix,
	  from_datetimez
  ) SELECT
    a.id,
    a.serial,
    a.active,
    a.name,
    a.type,
    a.out_of_order,
    a.is_loan,
    a.text,
    a.teamviewer_string,
    a.dhcp,
    a.ip,
    a.subnet,
    a.dns1,
    a.dns2,
    a.gateway,
    p.id AS pid,
    p.name AS place_name,
    p.city,
    p.street,
    p.number,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix,
	pa.from_datetimez
   FROM asset a
     LEFT JOIN asset_citrix ac ON ac.asset_id = a.id AND ac.until IS NULL
     LEFT JOIN citrix c ON ac.citrix_id = c.id
     LEFT JOIN places_assets pa ON a.id = pa.asset_id AND pa.id = (( SELECT max(places_assets.id) AS max
           FROM places_assets
          WHERE places_assets.asset_id = pa.asset_id))
     LEFT JOIN place p ON pa.place_id = p.id
   WHERE c.id = old.id
  GROUP BY a.id, p.id, pa.id
  ON CONFLICT(id) DO UPDATE SET
  	  serial = excluded.serial,
	  active = excluded.active,
	  name = excluded.name,
	  type = excluded.type,
	  out_of_order = excluded.out_of_order,
	  is_loan = excluded.is_loan,
	  text = excluded.text,
	  teamviewer_string = excluded.teamviewer_string,
	  dhcp = excluded.dhcp,
	  ip = excluded.ip,
	  subnet = excluded.subnet,
	  dns1 = excluded.dns1,
	  dns2 = excluded.dns2,
	  gateway = excluded.gateway,
	  place_id = excluded.place_id,
	  place_name = excluded.place_name, 
	  city = excluded.city, 
	  street = excluded.street, 
	  number = excluded.number,
	  from_datetimez = excluded.from_datetimez,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.asset_list_view_asset_citrix_change_trigger() OWNER TO postgres;

--
-- Name: asset_list_view_asset_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.asset_list_view_asset_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  DELETE FROM asset_list_table where id = old.id;
  RETURN OLD;
END
$$;


ALTER FUNCTION public.asset_list_view_asset_delete() OWNER TO postgres;

--
-- Name: asset_list_view_asset_place_delete_trigger(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE OR REPLACE FUNCTION public.asset_list_view_asset_place_delete_trigger() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO asset_list_table (
	  id,
	  serial,
	  active,
	  name,
	  type,
	  out_of_order,
	  is_loan,
	  text,
	  teamviewer_string,
	  dhcp,
	  ip,
	  subnet,
	  dns1,
	  dns2,
	  gateway,
	  place_id,
	  place_name, 
	  city, 
	  street, 
	  number, 
	  citrix,
	  from_datetimez
  ) SELECT
    a.id,
    a.serial,
    a.active,
    a.name,
    a.type,
    a.out_of_order,
    a.is_loan,
    a.text,
    a.teamviewer_string,
    a.dhcp,
    a.ip,
    a.subnet,
    a.dns1,
    a.dns2,
    a.gateway,
    p.id AS pid,
    p.name AS place_name,
    p.city,
    p.street,
    p.number,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix,
	pa.from_datetimez
   FROM asset a
     LEFT JOIN asset_citrix ac ON ac.asset_id = a.id AND ac.until IS NULL
     LEFT JOIN citrix c ON ac.citrix_id = c.id
     LEFT JOIN places_assets pa ON a.id = pa.asset_id AND pa.id = (( SELECT max(places_assets.id) AS max
           FROM places_assets
          WHERE places_assets.asset_id = pa.asset_id))
     LEFT JOIN place p ON pa.place_id = p.id
   WHERE a.id = old.asset_id
  GROUP BY a.id, p.id, pa.id
  ON CONFLICT(id) DO UPDATE SET
  	  serial = excluded.serial,
	  active = excluded.active,
	  name = excluded.name,
	  type = excluded.type,
	  out_of_order = excluded.out_of_order,
	  is_loan = excluded.is_loan,
	  text = excluded.text,
	  teamviewer_string = excluded.teamviewer_string,
	  dhcp = excluded.dhcp,
	  ip = excluded.ip,
	  subnet = excluded.subnet,
	  dns1 = excluded.dns1,
	  dns2 = excluded.dns2,
	  gateway = excluded.gateway,
	  place_id = excluded.place_id,
	  place_name = excluded.place_name, 
	  city = excluded.city, 
	  street = excluded.street, 
	  number = excluded.number,
	  from_datetimez = excluded.from_datetimez,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.asset_list_view_asset_place_delete_trigger() OWNER TO postgres;

--
-- Name: asset_list_view_asset_place_trigger_function(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.asset_list_view_asset_place_trigger_function() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  INSERT INTO asset_list_table (
	  id,
	  serial,
	  active,
	  name,
	  type,
	  out_of_order,
	  is_loan,
	  text,
	  teamviewer_string,
	  dhcp,
	  ip,
	  subnet,
	  dns1,
	  dns2,
	  gateway,
	  place_id,
	  place_name, 
	  city, 
	  street, 
	  number, 
	  citrix,
	  from_datetimez
  ) SELECT
    a.id,
    a.serial,
    a.active,
    a.name,
    a.type,
    a.out_of_order,
    a.is_loan,
    a.text,
    a.teamviewer_string,
    a.dhcp,
    a.ip,
    a.subnet,
    a.dns1,
    a.dns2,
    a.gateway,
    p.id AS pid,
    p.name AS place_name,
    p.city,
    p.street,
    p.number,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix,
	pa.from_datetimez
   FROM asset a
     LEFT JOIN asset_citrix ac ON ac.asset_id = a.id AND ac.until IS NULL
     LEFT JOIN citrix c ON ac.citrix_id = c.id
     LEFT JOIN places_assets pa ON a.id = pa.asset_id AND pa.id = (( SELECT max(places_assets.id) AS max
           FROM places_assets
          WHERE places_assets.asset_id = pa.asset_id))
     LEFT JOIN place p ON pa.place_id = p.id
   WHERE a.id = new.asset_id
  GROUP BY a.id, p.id, pa.id
  ON CONFLICT(id) DO UPDATE SET
  	  serial = excluded.serial,
	  active = excluded.active,
	  name = excluded.name,
	  type = excluded.type,
	  out_of_order = excluded.out_of_order,
	  is_loan = excluded.is_loan,
	  text = excluded.text,
	  teamviewer_string = excluded.teamviewer_string,
	  dhcp = excluded.dhcp,
	  ip = excluded.ip,
	  subnet = excluded.subnet,
	  dns1 = excluded.dns1,
	  dns2 = excluded.dns2,
	  gateway = excluded.gateway,
	  place_id = excluded.place_id,
	  place_name = excluded.place_name, 
	  city = excluded.city, 
	  street = excluded.street, 
	  number = excluded.number,
	  from_datetimez = excluded.from_datetimez,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.asset_list_view_asset_place_trigger_function() OWNER TO postgres;

--
-- Name: asset_list_view_place_trigger_function(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.asset_list_view_place_trigger_function() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  UPDATE asset_list_table SET
	  place_name = new.name, 
	  city = new.city, 
	  street = new.street, 
	  number = new.number
  WHERE place_id = new.id;
  RETURN new;
END
$$;


ALTER FUNCTION public.asset_list_view_place_trigger_function() OWNER TO postgres;

--
-- Name: asset_list_view_trigger_function(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.asset_list_view_trigger_function() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  INSERT INTO asset_list_table (
	  id,
	  serial,
	  active,
	  name,
	  type,
	  out_of_order,
	  is_loan,
	  text,
	  teamviewer_string,
	  dhcp,
	  ip,
	  subnet,
	  dns1,
	  dns2,
	  gateway,
	  place_id,
	  place_name, 
	  city, 
	  street, 
	  number, 
	  citrix,
	  from_datetimez
  ) SELECT
    a.id,
    a.serial,
    a.active,
    a.name,
    a.type,
    a.out_of_order,
    a.is_loan,
    a.text,
    a.teamviewer_string,
    a.dhcp,
    a.ip,
    a.subnet,
    a.dns1,
    a.dns2,
    a.gateway,
    p.id AS pid,
    p.name AS place_name,
    p.city,
    p.street,
    p.number,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix,
	pa.from_datetimez
   FROM asset a
     LEFT JOIN asset_citrix ac ON ac.asset_id = a.id AND ac.until IS NULL
     LEFT JOIN citrix c ON ac.citrix_id = c.id
     LEFT JOIN places_assets pa ON a.id = pa.asset_id AND pa.id = (( SELECT max(places_assets.id) AS max
           FROM places_assets
          WHERE places_assets.asset_id = pa.asset_id))
     LEFT JOIN place p ON pa.place_id = p.id
   WHERE a.id = new.id
  GROUP BY a.id, p.id, pa.id
  ON CONFLICT(id) DO UPDATE SET
  	  serial = excluded.serial,
	  active = excluded.active,
	  name = excluded.name,
	  type = excluded.type,
	  out_of_order = excluded.out_of_order,
	  is_loan = excluded.is_loan,
	  text = excluded.text,
	  teamviewer_string = excluded.teamviewer_string,
	  dhcp = excluded.dhcp,
	  ip = excluded.ip,
	  subnet = excluded.subnet,
	  dns1 = excluded.dns1,
	  dns2 = excluded.dns2,
	  gateway = excluded.gateway,
	  place_id = excluded.place_id,
	  place_name = excluded.place_name, 
	  city = excluded.city, 
	  street = excluded.street, 
	  number = excluded.number, 
	  from_datetimez = excluded.from_datetimez,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.asset_list_view_trigger_function() OWNER TO postgres;

--
-- Name: place_list_place_trigger_function(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.place_list_place_trigger_function() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN  
  INSERT INTO place_list_table (
	  id,
	  name,
	  longitude,
	  latitude,
	  street,
	  number,
	  postcode,
	  city,
	  tel1,
	  tel2,
	  tel3,
	  tel4,
	  fax,
	  opening_times,
	  website,
	  email,
	  text, 
	  active, 
	  citrix
  ) SELECT
    a.id, 
    a.name, 
    a.longitude, 
    a.latitude, 
    a.street, 
    a.number, 
    a.postcode, 
    a.city, 
    a.tel1, 
    a.tel2, 
    a.tel3, 
    a.tel4, 
    a.fax, 
    a.opening_times, 
    a.website, 
    a.email, 
    a.text, 
    a.active,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix
   FROM place a 
   LEFT OUTER JOIN place_citrix pc ON pc.place_id = a.id 
   LEFT OUTER JOIN citrix c ON pc.citrix_id = c.id 
   WHERE a.id = new.place_id
  GROUP BY a.id
  ON CONFLICT(id) DO UPDATE SET
  	  name = excluded.name,
	  longitude = excluded.longitude,
	  latitude = excluded.latitude,
	  street = excluded.street,
	  number = excluded.number,
	  postcode = excluded.postcode,
	  city = excluded.city,
	  tel1 = excluded.tel1,
	  tel2 = excluded.tel2,
	  tel3 = excluded.tel3,
	  tel4 = excluded.tel4,
	  fax = excluded.fax,
	  opening_times = excluded.opening_times, 
	  website = excluded.website, 
	  email = excluded.email, 
	  text = excluded.text, 
	  active = excluded.active,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.place_list_place_trigger_function() OWNER TO postgres;

--
-- Name: place_list_view_citrix_change_trigger(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.place_list_view_citrix_change_trigger() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  INSERT INTO place_list_table (
	  id,
	  name,
	  longitude,
	  latitude,
	  street,
	  number,
	  postcode,
	  city,
	  tel1,
	  tel2,
	  tel3,
	  tel4,
	  fax,
	  opening_times,
	  website,
	  email,
	  text, 
	  active, 
	  citrix
  ) SELECT
    a.id, 
    a.name, 
    a.longitude, 
    a.latitude, 
    a.street, 
    a.number, 
    a.postcode, 
    a.city, 
    a.tel1, 
    a.tel2, 
    a.tel3, 
    a.tel4, 
    a.fax, 
    a.opening_times, 
    a.website, 
    a.email, 
    a.text, 
    a.active,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix
   FROM place a 
   LEFT OUTER JOIN place_citrix pc ON pc.place_id = a.id 
   LEFT OUTER JOIN citrix c ON pc.citrix_id = c.id 
   WHERE c.id = old.id
  GROUP BY a.id
  ON CONFLICT(id) DO UPDATE SET
  	  name = excluded.name,
	  longitude = excluded.longitude,
	  latitude = excluded.latitude,
	  street = excluded.street,
	  number = excluded.number,
	  postcode = excluded.postcode,
	  city = excluded.city,
	  tel1 = excluded.tel1,
	  tel2 = excluded.tel2,
	  tel3 = excluded.tel3,
	  tel4 = excluded.tel4,
	  fax = excluded.fax,
	  opening_times = excluded.opening_times, 
	  website = excluded.website, 
	  email = excluded.email, 
	  text = excluded.text, 
	  active = excluded.active,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.place_list_view_citrix_change_trigger() OWNER TO postgres;

--
-- Name: place_list_view_place_citrix_delete_trigger(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.place_list_view_place_citrix_delete_trigger() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN  
  INSERT INTO place_list_table (
	  id,
	  name,
	  longitude,
	  latitude,
	  street,
	  number,
	  postcode,
	  city,
	  tel1,
	  tel2,
	  tel3,
	  tel4,
	  fax,
	  opening_times,
	  website,
	  email,
	  text, 
	  active, 
	  citrix
  ) SELECT
    a.id, 
    a.name, 
    a.longitude, 
    a.latitude, 
    a.street, 
    a.number, 
    a.postcode, 
    a.city, 
    a.tel1, 
    a.tel2, 
    a.tel3, 
    a.tel4, 
    a.fax, 
    a.opening_times, 
    a.website, 
    a.email, 
    a.text, 
    a.active,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix
   FROM place a 
   LEFT OUTER JOIN place_citrix pc ON pc.place_id = a.id 
   LEFT OUTER JOIN citrix c ON pc.citrix_id = c.id 
   WHERE a.id = old.place_id
  GROUP BY a.id
  ON CONFLICT(id) DO UPDATE SET
  	  name = excluded.name,
	  longitude = excluded.longitude,
	  latitude = excluded.latitude,
	  street = excluded.street,
	  number = excluded.number,
	  postcode = excluded.postcode,
	  city = excluded.city,
	  tel1 = excluded.tel1,
	  tel2 = excluded.tel2,
	  tel3 = excluded.tel3,
	  tel4 = excluded.tel4,
	  fax = excluded.fax,
	  opening_times = excluded.opening_times, 
	  website = excluded.website, 
	  email = excluded.email, 
	  text = excluded.text, 
	  active = excluded.active,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.place_list_view_place_citrix_delete_trigger() OWNER TO postgres;

--
-- Name: place_list_view_place_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.place_list_view_place_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  DELETE FROM place_list_table where id = old.id;
  RETURN OLD;
END
$$;


ALTER FUNCTION public.place_list_view_place_delete() OWNER TO postgres;

--
-- Name: place_list_view_place_trigger_function(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.place_list_view_place_trigger_function() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN  
  INSERT INTO place_list_table (
	  id,
	  name,
	  longitude,
	  latitude,
	  street,
	  number,
	  postcode,
	  city,
	  tel1,
	  tel2,
	  tel3,
	  tel4,
	  fax,
	  opening_times,
	  website,
	  email,
	  text, 
	  active, 
	  citrix
  ) SELECT
    a.id, 
    a.name, 
    a.longitude, 
    a.latitude, 
    a.street, 
    a.number, 
    a.postcode, 
    a.city, 
    a.tel1, 
    a.tel2, 
    a.tel3, 
    a.tel4, 
    a.fax, 
    a.opening_times, 
    a.website, 
    a.email, 
    a.text, 
    a.active,
    COALESCE(jsonb_agg(to_jsonb(c.*) - 'updated'::text - 'created'::text) FILTER (WHERE c.id IS NOT NULL), '[]'::jsonb) AS citrix
   FROM place a 
   LEFT OUTER JOIN place_citrix pc ON pc.place_id = a.id 
   LEFT OUTER JOIN citrix c ON pc.citrix_id = c.id 
   WHERE a.id = new.id
  GROUP BY a.id
  ON CONFLICT(id) DO UPDATE SET
  	  name = excluded.name,
	  longitude = excluded.longitude,
	  latitude = excluded.latitude,
	  street = excluded.street,
	  number = excluded.number,
	  postcode = excluded.postcode,
	  city = excluded.city,
	  tel1 = excluded.tel1,
	  tel2 = excluded.tel2,
	  tel3 = excluded.tel3,
	  tel4 = excluded.tel4,
	  fax = excluded.fax,
	  opening_times = excluded.opening_times, 
	  website = excluded.website, 
	  email = excluded.email, 
	  text = excluded.text, 
	  active = excluded.active,
	  citrix = excluded.citrix;
  RETURN NEW;
END
$$;


ALTER FUNCTION public.place_list_view_place_trigger_function() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: asset; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.asset (
    serial character varying(255),
    active boolean,
    name character varying(255),
    type character varying(255),
    out_of_order boolean,
    text character varying(2000),
    created timestamp without time zone DEFAULT now() NOT NULL,
    updated timestamp without time zone,
    id bigint NOT NULL,
    teamviewer_string character varying,
    is_loan boolean DEFAULT false NOT NULL,
    citrix_id bigint,
    dhcp boolean,
    ip character varying(255),
    subnet character varying(255),
    dns1 character varying(255),
    dns2 character varying(255),
    gateway character varying(255)
);


ALTER TABLE public.asset OWNER TO postgres;

--
-- Name: asset_citrix; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.asset_citrix (
    id bigint NOT NULL,
    asset_id bigint NOT NULL,
    citrix_id bigint NOT NULL,
    from_date timestamp with time zone DEFAULT now() NOT NULL,
    until timestamp with time zone
);


ALTER TABLE public.asset_citrix OWNER TO postgres;

--
-- Name: asset_citrix_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.asset_citrix_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.asset_citrix_id_seq OWNER TO postgres;

--
-- Name: asset_citrix_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.asset_citrix_id_seq OWNED BY public.asset_citrix.id;


--
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
-- Name: asset_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.asset_id_seq OWNED BY public.asset.id;


--
-- Name: asset_list_table; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.asset_list_table (
    id bigint,
    serial character varying,
    active boolean,
    name character varying,
    type character varying,
    out_of_order boolean,
    is_loan boolean,
    text text,
    teamviewer_string character varying,
    dhcp boolean,
    ip character varying,
    subnet character varying,
    dns1 character varying,
    dns2 character varying,
    gateway character varying,
    place_name character varying,
    city character varying,
    street character varying,
    number character varying,
    citrix jsonb,
    place_id bigint,
    from_datetimez timestamp with time zone
);


ALTER TABLE public.asset_list_table OWNER TO postgres;

--
-- Name: asset_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.asset_user (
    id bigint NOT NULL,
    person_id bigint NOT NULL,
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
-- Name: citrix_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.citrix_id_seq OWNED BY public.citrix.id;


--
-- Name: enduser; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.enduser (
    id bigint NOT NULL,
    person_id bigint,
    place_id bigint,
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
-- Name: enduser_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.enduser_id_seq OWNED BY public.asset_user.id;


--
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
-- Name: enduser_id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.enduser_id_seq1 OWNED BY public.enduser.id;


--
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
-- Name: person_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.person_id_seq OWNED BY public.person.id;


--
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
-- Name: place_citrix; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.place_citrix (
    id bigint NOT NULL,
    citrix_id integer NOT NULL,
    place_id integer NOT NULL
);


ALTER TABLE public.place_citrix OWNER TO postgres;

--
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
-- Name: place_citrix_citrix_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_citrix_citrix_seq OWNED BY public.place_citrix.citrix_id;


--
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
-- Name: place_citrix_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_citrix_id_seq OWNED BY public.place_citrix.id;


--
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
-- Name: place_citrix_place_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_citrix_place_seq OWNED BY public.place_citrix.place_id;


--
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
-- Name: place_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.place_id_seq OWNED BY public.place.id;


--
-- Name: place_list_table; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.place_list_table (
    id bigint,
    name character varying,
    longitude character varying,
    latitude character varying,
    street character varying,
    number character varying,
    postcode character varying,
    city character varying,
    tel1 character varying,
    tel2 character varying,
    tel3 character varying,
    tel4 character varying,
    fax character varying,
    opening_times character varying(2000),
    website character varying,
    email character varying,
    text character varying(2000),
    active boolean,
    citrix jsonb
);


ALTER TABLE public.place_list_table OWNER TO postgres;

--
-- Name: places_assets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.places_assets (
    id bigint NOT NULL,
    place_id bigint NOT NULL,
    asset_id bigint NOT NULL,
    deliverer_person_id bigint,
    receiver_person_id bigint,
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
-- Name: places_assets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.places_assets_id_seq OWNED BY public.places_assets.id;


--
-- Name: asset id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset ALTER COLUMN id SET DEFAULT nextval('public.asset_id_seq'::regclass);


--
-- Name: asset_citrix id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_citrix ALTER COLUMN id SET DEFAULT nextval('public.asset_citrix_id_seq'::regclass);


--
-- Name: asset_user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user ALTER COLUMN id SET DEFAULT nextval('public.enduser_id_seq'::regclass);


--
-- Name: citrix id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citrix ALTER COLUMN id SET DEFAULT nextval('public.citrix_id_seq'::regclass);


--
-- Name: enduser id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser ALTER COLUMN id SET DEFAULT nextval('public.enduser_id_seq1'::regclass);


--
-- Name: person id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.person ALTER COLUMN id SET DEFAULT nextval('public.person_id_seq'::regclass);


--
-- Name: place id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place ALTER COLUMN id SET DEFAULT nextval('public.place_id_seq'::regclass);


--
-- Name: place_citrix id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix ALTER COLUMN id SET DEFAULT nextval('public.place_citrix_id_seq'::regclass);


--
-- Name: place_citrix citrix_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix ALTER COLUMN citrix_id SET DEFAULT nextval('public.place_citrix_citrix_seq'::regclass);


--
-- Name: place_citrix place_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix ALTER COLUMN place_id SET DEFAULT nextval('public.place_citrix_place_seq'::regclass);


--
-- Name: places_assets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets ALTER COLUMN id SET DEFAULT nextval('public.places_assets_id_seq'::regclass);


--
-- Name: asset_citrix asset_citrix_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_citrix
    ADD CONSTRAINT asset_citrix_pkey PRIMARY KEY (id);


--
-- Name: asset_list_table asset_list_table_id_uniq; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_list_table
    ADD CONSTRAINT asset_list_table_id_uniq UNIQUE (id);


--
-- Name: asset asset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT asset_pkey PRIMARY KEY (id);


--
-- Name: asset asset_teamviewer_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT asset_teamviewer_id_unique UNIQUE (teamviewer_string);


--
-- Name: asset_user asset_user_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user
    ADD CONSTRAINT asset_user_email_unique UNIQUE (email);


--
-- Name: citrix citrix_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citrix
    ADD CONSTRAINT citrix_number_unique UNIQUE (citrix_number);


--
-- Name: citrix citrix_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.citrix
    ADD CONSTRAINT citrix_pkey PRIMARY KEY (id);


--
-- Name: asset_user enduser_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user
    ADD CONSTRAINT enduser_pkey PRIMARY KEY (id);


--
-- Name: enduser enduser_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser
    ADD CONSTRAINT enduser_pkey1 PRIMARY KEY (id);


--
-- Name: person person_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.person
    ADD CONSTRAINT person_pkey PRIMARY KEY (id);


--
-- Name: place_citrix place_citrix_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix
    ADD CONSTRAINT place_citrix_pkey PRIMARY KEY (id);


--
-- Name: place_list_table place_list_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_list_table
    ADD CONSTRAINT place_list_unique UNIQUE (id);


--
-- Name: place place_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place
    ADD CONSTRAINT place_pkey PRIMARY KEY (id);


--
-- Name: places_assets places_assets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT places_assets_pkey PRIMARY KEY (id);


--
-- Name: asset serial_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT serial_unique UNIQUE (serial);


--
-- Name: asset_asset_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_asset_name_trgm_gin ON public.asset USING gin (name public.gin_trgm_ops);


--
-- Name: asset_citrix_asset_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_citrix_asset_id_idx ON public.asset_citrix USING btree (asset_id);


--
-- Name: asset_citrix_citrix_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_citrix_citrix_id_idx ON public.asset_citrix USING btree (citrix_id);


--
-- Name: asset_citrix_from_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_citrix_from_idx ON public.asset_citrix USING btree (from_date);


--
-- Name: asset_citrix_until_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_citrix_until_idx ON public.asset_citrix USING btree (until);


--
-- Name: asset_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX asset_id_idx ON public.asset_list_table USING btree (id);


--
-- Name: asset_list_citrix_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_citrix_trgm_gin ON public.asset_list_table USING gin (citrix jsonb_path_ops);


--
-- Name: asset_list_city_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_city_trgm_gin ON public.asset_list_table USING gin (city public.gin_trgm_ops);


--
-- Name: asset_list_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_name_trgm_gin ON public.asset_list_table USING gin (name public.gin_trgm_ops);


--
-- Name: asset_list_place_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_place_id ON public.asset_list_table USING btree (place_id);


--
-- Name: asset_list_place_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_place_name_trgm_gin ON public.asset_list_table USING gin (place_name public.gin_trgm_ops);


--
-- Name: asset_list_serial_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_serial_trgm_gin ON public.asset_list_table USING gin (serial public.gin_trgm_ops);


--
-- Name: asset_list_street_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_street_trgm_gin ON public.asset_list_table USING gin (street public.gin_trgm_ops);


--
-- Name: asset_list_teamviewer_string_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_teamviewer_string_trgm_gin ON public.asset_list_table USING gin (teamviewer_string public.gin_trgm_ops);


--
-- Name: asset_list_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_text_trgm_gin ON public.asset_list_table USING gin (text public.gin_trgm_ops);


--
-- Name: asset_list_type_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_list_type_trgm_gin ON public.asset_list_table USING gin (type public.gin_trgm_ops);


--
-- Name: asset_serial_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_serial_trgm_gin ON public.asset USING gin (serial public.gin_trgm_ops);


--
-- Name: asset_teamviewer_id_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_teamviewer_id_trgm_gin ON public.asset USING gin (teamviewer_string public.gin_trgm_ops);


--
-- Name: asset_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_text_trgm_gin ON public.asset USING gin (text public.gin_trgm_ops);


--
-- Name: asset_type_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_type_trgm_gin ON public.asset USING gin (type public.gin_trgm_ops);


--
-- Name: asset_user_api_token; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_api_token ON public.asset_user USING btree (api_token);


--
-- Name: asset_user_api_token_valid; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_api_token_valid ON public.asset_user USING btree (api_token, api_token_valid_until);


--
-- Name: asset_user_password_reset_hash_valid; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_password_reset_hash_valid ON public.asset_user USING btree (password_reset_hash, password_reset_date);


--
-- Name: asset_user_person_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX asset_user_person_idx ON public.asset_user USING btree (person_id);


--
-- Name: citrix_number_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX citrix_number_trgm_gin ON public.citrix USING gin (citrix_number public.gin_trgm_ops);


--
-- Name: citrix_password_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX citrix_password_trgm_gin ON public.citrix USING gin (password public.gin_trgm_ops);


--
-- Name: citrix_show_id_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX citrix_show_id_trgm_gin ON public.citrix USING gin (show_id public.gin_trgm_ops);


--
-- Name: enduser_email_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_email_trgm_gin ON public.asset_user USING gin (email public.gin_trgm_ops);


--
-- Name: enduser_mobile_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_mobile_trgm_gin ON public.enduser USING gin (mobile public.gin_trgm_ops);


--
-- Name: enduser_person_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_person_idx ON public.enduser USING btree (person_id);


--
-- Name: enduser_place_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_place_idx ON public.enduser USING btree (place_id);


--
-- Name: enduser_teamviewer_id_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_teamviewer_id_trgm_gin ON public.enduser USING gin (text public.gin_trgm_ops);


--
-- Name: enduser_tel_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_tel_trgm_gin ON public.enduser USING gin (tel public.gin_trgm_ops);


--
-- Name: enduser_user_email_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX enduser_user_email_trgm_gin ON public.enduser USING gin (email public.gin_trgm_ops);


--
-- Name: fki_asset_citrix_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_asset_citrix_fk ON public.asset USING btree (citrix_id);


--
-- Name: fki_asset_user_person; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_asset_user_person ON public.asset_user USING btree (person_id);


--
-- Name: fki_enduser_person_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_enduser_person_fk ON public.enduser USING btree (person_id);


--
-- Name: fki_enduser_place_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_enduser_place_fk ON public.enduser USING btree (place_id);


--
-- Name: fki_person_citrix_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_person_citrix_fk ON public.place USING btree (citrix);


--
-- Name: fki_place_citrix_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_place_citrix_fk ON public.place_citrix USING btree (citrix_id);


--
-- Name: fki_place_citrix_place_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_place_citrix_place_fk ON public.place_citrix USING btree (place_id);


--
-- Name: fki_places_assets_asset_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_asset_fk ON public.places_assets USING btree (asset_id);


--
-- Name: fki_places_assets_deliverer_person_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_deliverer_person_fk ON public.places_assets USING btree (deliverer_person_id);


--
-- Name: fki_places_assets_pickup_person_id_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_pickup_person_id_fk ON public.places_assets USING btree (pickup_person_id);


--
-- Name: fki_places_assets_pickup_responsible_person_id_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_pickup_responsible_person_id_fk ON public.places_assets USING btree (pickup_responsible_person_id);


--
-- Name: fki_places_assets_place_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_place_fk ON public.places_assets USING btree (place_id);


--
-- Name: fki_places_assets_receiver_person_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_places_assets_receiver_person_fk ON public.places_assets USING btree (receiver_person_id);


--
-- Name: person_first_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX person_first_name_trgm_gin ON public.person USING gin (first_name public.gin_trgm_ops);


--
-- Name: person_last_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX person_last_name_trgm_gin ON public.person USING gin (last_name public.gin_trgm_ops);


--
-- Name: place_city_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_city_trgm_gin ON public.place USING gin (city public.gin_trgm_ops);


--
-- Name: place_email_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_email_trgm_gin ON public.place USING gin (email public.gin_trgm_ops);


--
-- Name: place_fax_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_fax_trgm_gin ON public.place USING gin (fax public.gin_trgm_ops);


--
-- Name: place_groupy_by_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_groupy_by_idx ON public.place USING btree (id, name, longitude, latitude, street, number, postcode, city, tel1, tel2, tel3, tel4, fax, opening_times, website, email, text, active);


--
-- Name: place_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_id_idx ON public.place_list_table USING btree (id);


--
-- Name: place_list_citrix_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_citrix_trgm_gin ON public.place_list_table USING gin (citrix jsonb_path_ops);


--
-- Name: place_list_city_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_city_trgm_gin ON public.place_list_table USING gin (city public.gin_trgm_ops);


--
-- Name: place_list_email_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_email_trgm_gin ON public.place_list_table USING gin (email public.gin_trgm_ops);


--
-- Name: place_list_fax_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_fax_trgm_gin ON public.place_list_table USING gin (fax public.gin_trgm_ops);


--
-- Name: place_list_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_name_trgm_gin ON public.place_list_table USING gin (name public.gin_trgm_ops);


--
-- Name: place_list_postcode_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_postcode_trgm_gin ON public.place_list_table USING gin (postcode public.gin_trgm_ops);


--
-- Name: place_list_street_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_street_trgm_gin ON public.place_list_table USING gin (street public.gin_trgm_ops);


--
-- Name: place_list_tel1_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_tel1_trgm_gin ON public.place_list_table USING gin (tel1 public.gin_trgm_ops);


--
-- Name: place_list_tel2_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_tel2_trgm_gin ON public.place_list_table USING gin (tel2 public.gin_trgm_ops);


--
-- Name: place_list_tel3_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_tel3_trgm_gin ON public.place_list_table USING gin (tel3 public.gin_trgm_ops);


--
-- Name: place_list_tel4_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_tel4_trgm_gin ON public.place_list_table USING gin (tel4 public.gin_trgm_ops);


--
-- Name: place_list_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_text_trgm_gin ON public.place_list_table USING gin (text public.gin_trgm_ops);


--
-- Name: place_list_website_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_list_website_trgm_gin ON public.place_list_table USING gin (website public.gin_trgm_ops);


--
-- Name: place_name_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_name_trgm_gin ON public.place USING gin (name public.gin_trgm_ops);


--
-- Name: place_postcode_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_postcode_trgm_gin ON public.place USING gin (postcode public.gin_trgm_ops);


--
-- Name: place_street_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_street_trgm_gin ON public.place USING gin (street public.gin_trgm_ops);


--
-- Name: place_tel1_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel1_trgm_gin ON public.place USING gin (tel1 public.gin_trgm_ops);


--
-- Name: place_tel2_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel2_trgm_gin ON public.place USING gin (tel2 public.gin_trgm_ops);


--
-- Name: place_tel3_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel3_trgm_gin ON public.place USING gin (tel3 public.gin_trgm_ops);


--
-- Name: place_tel4_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_tel4_trgm_gin ON public.place USING gin (tel4 public.gin_trgm_ops);


--
-- Name: place_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_text_trgm_gin ON public.place USING gin (text public.gin_trgm_ops);


--
-- Name: place_website_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX place_website_trgm_gin ON public.place USING gin (website public.gin_trgm_ops);


--
-- Name: places_assets_asset_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_asset_idx ON public.places_assets USING btree (asset_id);


--
-- Name: places_assets_delivery_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_delivery_datetimez_idx ON public.places_assets USING btree (delivery_datetimez);


--
-- Name: places_assets_from_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_from_datetimez_idx ON public.places_assets USING btree (from_datetimez);


--
-- Name: places_assets_pickup_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_pickup_datetimez_idx ON public.places_assets USING btree (pickup_datetimez);


--
-- Name: places_assets_place_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_place_idx ON public.places_assets USING btree (place_id);


--
-- Name: places_assets_text_trgm_gin; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_text_trgm_gin ON public.places_assets USING gin (text public.gin_trgm_ops);


--
-- Name: places_assets_until_datetimez_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX places_assets_until_datetimez_idx ON public.places_assets USING btree (until_datetimez);


--
-- Name: asset_citrix asset_citrix_delete_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER asset_citrix_delete_trigger AFTER DELETE ON public.asset_citrix FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_asset_place_delete_trigger();


--
-- Name: asset_citrix asset_citrix_insert_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER asset_citrix_insert_update_trigger AFTER INSERT OR UPDATE ON public.asset_citrix FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_asset_place_trigger_function();


--
-- Name: asset asset_delete_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER asset_delete_trigger AFTER DELETE ON public.asset FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_asset_delete();


--
-- Name: asset asset_insert_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER asset_insert_update_trigger AFTER INSERT OR UPDATE ON public.asset FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_trigger_function();


--
-- Name: citrix citrix_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER citrix_update_trigger AFTER UPDATE ON public.citrix FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_asset_citrix_change_trigger();


--
-- Name: citrix citrix_update_trigger_2; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER citrix_update_trigger_2 AFTER INSERT OR DELETE OR UPDATE ON public.citrix FOR EACH ROW EXECUTE FUNCTION public.place_list_view_citrix_change_trigger();


--
-- Name: place place_asset_list_view_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER place_asset_list_view_update_trigger AFTER UPDATE ON public.place FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_place_trigger_function();


--
-- Name: place_citrix place_citrix_place_delete_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER place_citrix_place_delete_trigger AFTER DELETE ON public.place_citrix FOR EACH ROW EXECUTE FUNCTION public.place_list_view_place_citrix_delete_trigger();


--
-- Name: place_citrix place_citrix_place_update_insert_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER place_citrix_place_update_insert_trigger AFTER INSERT OR UPDATE ON public.place_citrix FOR EACH ROW EXECUTE FUNCTION public.place_list_place_trigger_function();


--
-- Name: place place_place_list_view_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER place_place_list_view_update_trigger AFTER INSERT OR UPDATE ON public.place FOR EACH ROW EXECUTE FUNCTION public.place_list_view_place_trigger_function();


--
-- Name: place place_place_lost_view_delete_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER place_place_lost_view_delete_trigger AFTER DELETE ON public.place FOR EACH ROW EXECUTE FUNCTION public.place_list_view_place_delete();


--
-- Name: places_assets places_assets_delete_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER places_assets_delete_trigger AFTER DELETE ON public.places_assets FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_asset_place_delete_trigger();


--
-- Name: places_assets places_assets_insert_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER places_assets_insert_update_trigger AFTER INSERT OR UPDATE ON public.places_assets FOR EACH ROW EXECUTE FUNCTION public.asset_list_view_asset_place_trigger_function();


--
-- Name: asset_citrix asset_citrix_asset_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_citrix
    ADD CONSTRAINT asset_citrix_asset_id_fk FOREIGN KEY (asset_id) REFERENCES public.asset(id) NOT VALID;


--
-- Name: asset_citrix asset_citrix_citrix_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_citrix
    ADD CONSTRAINT asset_citrix_citrix_id_fk FOREIGN KEY (citrix_id) REFERENCES public.citrix(id) NOT VALID;


--
-- Name: asset asset_citrix_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset
    ADD CONSTRAINT asset_citrix_fk FOREIGN KEY (citrix_id) REFERENCES public.citrix(id) NOT VALID;


--
-- Name: asset_user asset_user_person; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.asset_user
    ADD CONSTRAINT asset_user_person FOREIGN KEY (person_id) REFERENCES public.person(id) NOT VALID;


--
-- Name: places_assets deliverer_person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT deliverer_person_user_fk FOREIGN KEY (deliverer_person_id) REFERENCES public.asset_user(id) NOT VALID;


--
-- Name: enduser enduser_person_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser
    ADD CONSTRAINT enduser_person_fk FOREIGN KEY (person_id) REFERENCES public.person(id) NOT VALID;


--
-- Name: enduser enduser_place_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.enduser
    ADD CONSTRAINT enduser_place_fk FOREIGN KEY (place_id) REFERENCES public.place(id) NOT VALID;


--
-- Name: places_assets pickup_person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT pickup_person_user_fk FOREIGN KEY (pickup_person_id) REFERENCES public.asset_user(id) NOT VALID;


--
-- Name: places_assets pickup_responsible_user_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT pickup_responsible_user_id_fk FOREIGN KEY (pickup_responsible_person_id) REFERENCES public.asset_user(id) NOT VALID;


--
-- Name: place_citrix place_citrix_citrix_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix
    ADD CONSTRAINT place_citrix_citrix_fk FOREIGN KEY (citrix_id) REFERENCES public.citrix(id) NOT VALID;


--
-- Name: place_citrix place_citrix_place_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.place_citrix
    ADD CONSTRAINT place_citrix_place_fk FOREIGN KEY (place_id) REFERENCES public.place(id) NOT VALID;


--
-- Name: places_assets places_assets_asset_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT places_assets_asset_fk FOREIGN KEY (asset_id) REFERENCES public.asset(id) NOT VALID;


--
-- Name: places_assets places_assets_place_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT places_assets_place_fk FOREIGN KEY (place_id) REFERENCES public.place(id) NOT VALID;


--
-- Name: places_assets receiver_person_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places_assets
    ADD CONSTRAINT receiver_person_user_fk FOREIGN KEY (receiver_person_id) REFERENCES public.asset_user(id) NOT VALID;


--
-- PostgreSQL database dump complete
--

