#!/usr/bin/env python3
"""Isolated dotenv checks: never read or replace the developer's .env."""
import json, os, pathlib, shutil, subprocess, tempfile, unittest
ROOT = pathlib.Path(__file__).resolve().parents[1]
class Environment(unittest.TestCase):
 def setUp(self):
  self.tmp = tempfile.TemporaryDirectory(); self.root = pathlib.Path(self.tmp.name)/'app'
  (self.root/'server').mkdir(parents=True)
  shutil.copy(ROOT/'server/bootstrap.php', self.root/'server/bootstrap.php')
  (self.root/'vendor').symlink_to(ROOT/'vendor', target_is_directory=True)
  self.env = {k:v for k,v in os.environ.items() if not k.startswith(('DB_', 'APP_CONFIG'))}
 def tearDown(self): self.tmp.cleanup()
 def run_php(self, code):
  return subprocess.run(['php','-r','require '+json.dumps(str(self.root/'server/bootstrap.php'))+';'+code],env=self.env,cwd='/',capture_output=True,text=True)
 def test_real_file_special_password_and_cwd(self):
  (self.root/'.env').write_text('DB_NAME=synthetic\nDB_PASS=\'hash # dollar $ spaces "quoted"\'\n')
  p=self.run_php("echo json_encode([app_env('DB_NAME'),app_env('DB_PASS'),getenv('DB_NAME')]);")
  self.assertEqual(json.loads(p.stdout),['synthetic','hash # dollar $ spaces "quoted"',False])
 def test_process_wins(self):
  (self.root/'.env').write_text('DB_NAME=file\nDB_PASS=file\n')
  self.env.update(DB_NAME='process',DB_PASS='')
  self.assertEqual(self.run_php("echo json_encode([app_env('DB_NAME'),app_env('DB_PASS')]);").stdout,'["process",""]')
 def test_legacy_config_without_dotenv(self):
  private=pathlib.Path(self.tmp.name)/'asistencia-private.php';private.write_text("<?php return ['DB_NAME'=>'legacy'];")
  # db() must really require the legacy file; the marker precedes a deliberate failure.
  private.write_text("<?php echo 'LEGACY_LOADED'; return ['DB_NAME'=>''];")
  p=self.run_php('try { db(); } catch (Throwable $e) { echo "_EXPECTED_MISSING"; }')
  self.assertEqual(p.stdout,'LEGACY_LOADED_EXPECTED_MISSING')
  custom=pathlib.Path(self.tmp.name)/'custom.php'
  custom.write_text("<?php echo 'CUSTOM_LOADED'; return ['DB_NAME'=>''];")
  self.env['APP_CONFIG']=str(custom)
  self.assertEqual(self.run_php('try { db(); } catch (Throwable $e) {}').stdout,'CUSTOM_LOADED')
 def test_app_config_from_dotenv(self):
  (self.root/'.env').write_text('APP_CONFIG=/synthetic/private.php\n')
  self.assertEqual(self.run_php("echo app_env('APP_CONFIG');").stdout,'/synthetic/private.php')
 def test_malformed_no_leak(self):
  secret='SYNTHETIC_SECRET_MUST_NOT_LEAK'
  (self.root/'.env').write_text('DB_PASS="'+secret+'\n')
  p=self.run_php('echo "UNSAFE_CONTINUATION";')
  self.assertNotIn(secret,p.stdout+p.stderr);self.assertNotIn('UNSAFE_CONTINUATION',p.stdout)
  self.assertIn('Error interno',p.stdout)
 def test_gitignore_and_http_rules(self):
  p=subprocess.run(['git','check-ignore','--no-index','.env','.env.local','.env.example'],cwd=ROOT,capture_output=True,text=True)
  self.assertEqual(set(p.stdout.splitlines()),{'.env','.env.local'})
  text=(ROOT/'.htaccess').read_text();self.assertIn(r'\.env(?:\..*)?$',text)
if __name__=='__main__': unittest.main(verbosity=2)
