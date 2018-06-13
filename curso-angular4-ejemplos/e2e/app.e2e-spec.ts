import { CursoAngular4Page } from './app.po';

describe('curso-angular4 App', () => {
  let page: CursoAngular4Page;

  beforeEach(() => {
    page = new CursoAngular4Page();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
