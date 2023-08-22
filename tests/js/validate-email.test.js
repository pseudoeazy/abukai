import { jest } from "@jest/globals";
import { isValidEmail } from "../../app/assets/js/customer-information";

describe("isValidEmail", () => {
  it("should return true when a valid email address is provided", () => {
    const email = "test@example.com";
    const result = isValidEmail(email);
    expect(result).toBe(true);
  });

  it('should return false when an email address is missing the "@" character', () => {
    const email = "testexample.com";
    const result = isValidEmail(email);
    expect(result).toBe(false);
  });

  it('should return false when an email address is missing the "." character', () => {
    const email = "test@examplecom";
    const result = isValidEmail(email);
    expect(result).toBe(false);
  });

  it('should return false when an email address has multiple "@" characters', () => {
    const email = "test@@example.com";
    const result = isValidEmail(email);
    expect(result).toBe(false);
  });

  it("should return false when an email address has special characters other than dots and hyphens", () => {
    const email = "test!@example.com";
    const result = isValidEmail(email);
    expect(result).toBe(false);
  });
});
