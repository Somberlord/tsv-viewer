--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: tsv_user; Type: TABLE; Schema: public; Owner: somberlord; Tablespace:
--

CREATE TABLE tsv_user (
    uid integer NOT NULL,
    name character varying(50)
);


ALTER TABLE public.tsv_user OWNER TO somberlord;

--
-- Name: user_uid_seq; Type: SEQUENCE; Schema: public; Owner: somberlord
--

CREATE SEQUENCE user_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_uid_seq OWNER TO somberlord;

--
-- Name: user_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: somberlord
--

ALTER SEQUENCE user_uid_seq OWNED BY tsv_user.uid;


--
-- Name: uid; Type: DEFAULT; Schema: public; Owner: somberlord
--

ALTER TABLE tsv_user ALTER COLUMN uid SET DEFAULT nextval('user_uid_seq'::regclass);


--
-- Name: tsv_user_name_key; Type: CONSTRAINT; Schema: public; Owner: somberlord; Tablespace:
--

ALTER TABLE ONLY tsv_user
    ADD CONSTRAINT tsv_user_name_key UNIQUE (name);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: somberlord; Tablespace:
--

ALTER TABLE ONLY tsv_user
    ADD CONSTRAINT user_pkey PRIMARY KEY (uid);


--
-- PostgreSQL database dump complete
--
