import { jest } from "@jest/globals";
import { validateInput } from "../../app/assets/js/customer-information";
describe("validateInput", () => {
  it("should add error class when element value is empty", () => {
    const element = {
      name: "name",
      value: "",
      classList: { add: jest.fn(), remove: jest.fn() },
    };
    validateInput(element);
    expect(element.classList.add).toHaveBeenCalled();
  });

  it("should not add error class when element value is not empty ", () => {
    const element = {
      name: "name",
      value: "John",
      classList: { add: jest.fn(), remove: jest.fn() },
    };
    validateInput(element);
    expect(element.classList.add).not.toHaveBeenCalled();
  });

  it('should not add error class when element value is a valid email and element name is "email"', () => {
    const element = {
      name: "email",
      value: "test@example.com",
      classList: { add: jest.fn(), remove: jest.fn() },
    };
    validateInput(element);
    expect(element.classList.add).not.toHaveBeenCalled();
  });

  it('should add error class when element value is not a valid email and element name is "email"', () => {
    const element = {
      name: "email",
      value: "invalidemail",
      classList: { add: jest.fn(), remove: jest.fn() },
    };
    validateInput(element);
    expect(element.classList.add).toHaveBeenCalled();
  });

  it('should not add error class when element name is "countries" or "picture"', () => {
    const element1 = {
      name: "countries",
      value: "",
      classList: {
        add: jest.fn(),
        remove: jest.fn(),
      },
    };
    const element2 = {
      name: "picture",
      value: "",
      classList: {
        add: jest.fn(),
        remove: jest.fn(),
      },
    };
    validateInput(element1);
    validateInput(element2);
    expect(element1.classList.add).not.toHaveBeenCalled();
    expect(element2.classList.add).not.toHaveBeenCalled();
  });
});
